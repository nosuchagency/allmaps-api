<?php

namespace Tests\Feature\Users;

use App\Locale;
use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
        $this->create()->assertStatus(201);
        $this->assertCount(2, User::all());
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
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['users.create'])
        );

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
            'password' => $this->faker->password,
            'locale' => $this->faker->randomElement(Locale::LOCALES),
            'email' => $this->faker->email,
            'role' => factory(Role::class)->create(),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
