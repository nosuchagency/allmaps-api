<?php

namespace Tests\Feature\Users;

use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var string
     */
    protected $password;

    protected function setUp(): void
    {
        parent::setUp();
        $this->password = $this->faker->password(8);
    }

    /** @test */
    public function a_guest_cannot_create_users()
    {
        $this->postJson(route('users.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_users()
    {
        $this->signIn();

        $this->postJson(route('users.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_users()
    {
        $attributes = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'locale' => 'en'
        ];

        $userResponse = $this->create($attributes)->assertStatus(201)->decodeResponseJson();

        $attributes['id'] = $userResponse['id'];

        $this->assertDatabaseHas('users', $attributes);

        $user = User::find($userResponse['id']);
        $this->assertTrue(Hash::check($this->password, $user->password));
        $this->assertCount(2, $user->tags);
        $this->assertInstanceOf(Category::class, $user->category);
    }

    /** @test */
    public function it_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_requires_a_password()
    {
        $this->create(['password' => null])->assertJsonValidationErrors('password');
    }

    /** @test */
    public function it_requires_a_valid_email()
    {
        $this->create(['email' => null])->assertJsonValidationErrors('email');
        $this->create(['email' => 'not-a-valid-email'])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function it_requires_locale_to_be_valid()
    {
        $this->create(['locale' => 'not-a-valid-locale'])->assertJsonValidationErrors('locale');
    }

    /** @test */
    public function it_requires_a_valid_role()
    {
        $this->create(['role' => null])->assertJsonValidationErrors('role');
        $this->create(['role' => 'not-a-valid-role'])->assertJsonValidationErrors('role.id');
        $this->create(['role' => ['not-a-valid-role-object']])->assertJsonValidationErrors('role.id');
    }

    /** @test */
    public function category_needs_to_be_a_valid_category_object()
    {
        $this->create(['category' => ['id' => 2]])->assertJsonValidationErrors(['category.id']);
        $this->create(['category' => ['not-a-valid-category-object']])->assertJsonValidationErrors(['category']);
    }

    /** @test */
    public function tags_needs_to_be_an_array_of_valid_tag_objects()
    {
        $this->create(['tags' => 'not-a-valid-tags-array'])->assertJsonValidationErrors(['tags']);
        $this->create(['tags' => ['not-a-valid-tag-object']])->assertJsonValidationErrors(['tags.0.id']);
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function create($attributes = [])
    {
        $role = $this->createRoleWithPermissions(['user:create']);

        $this->signIn(null, $role);

        return $this->postJson(route('users.store'), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'name' => $this->faker->name,
            'password' => $this->password,
            'password_confirmation' => $this->password,
            'locale' => 'en',
            'email' => $this->faker->email,
            'role' => factory(Role::class)->create(),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
