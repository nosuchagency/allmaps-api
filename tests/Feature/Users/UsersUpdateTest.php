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

class UsersUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

        $attributes = ['id' => $user->id, 'name' => $this->faker->name];

        $this->update($user, $attributes)->assertOk();

        $this->assertDatabaseHas('users', $attributes);
    }

    /**
     * @param $user
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($user, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['users.update'])
        );

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
            'password' => $this->faker->password,
            'locale' => $this->faker->randomElement(Locale::LOCALES),
            'email' => $this->faker->email,
            'role' => factory(Role::class)->create(),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
