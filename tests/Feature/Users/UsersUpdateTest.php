<?php

namespace Tests\Feature\Users;

use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersUpdateTest extends TestCase
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
    public function a_guest_cannot_update_users()
    {
        $user = factory(User::class)->create();

        $this->putJson(route('users.update', ['user' => $user]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_users()
    {
        $this->signIn();

        $user = factory(User::class)->create();

        $this->putJson(route('users.update', ['user' => $user]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_users()
    {
        $user = factory(User::class)->create();

        $attributes = [
            'id' => $user->id,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'locale' => 'en'
        ];

        $this->update($user, $attributes)->assertOk();

        $this->assertDatabaseHas('users', $attributes);
    }

    /** @test */
    public function the_role_cant_be_empty_if_present()
    {
        $user = factory(User::class)->create();

        $this->update($user, ['role' => []])->assertJsonValidationErrors('role');
    }

    /** @test */
    public function the_role_id_is_required_if_role_object_is_filled()
    {
        $user = factory(User::class)->create();

        $this->update($user, ['role' => ['name' => 'test']])->assertJsonValidationErrors('role.id');
    }

    /** @test */
    public function the_role_id_needs_to_belong_to_an_existing_role()
    {
        $user = factory(User::class)->create();

        $this->update($user, ['role' => ['id' => 10]])->assertJsonValidationErrors('role.id');
    }

    /**
     * @param $user
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($user, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['user:update']);

        $this->signIn(null, $role);

        return $this->putJson(route('users.update', ['user' => $user]), $this->validFields($attributes));
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
