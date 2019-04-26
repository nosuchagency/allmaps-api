<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_users()
    {
        $this->postJson(route('users.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('users.destroy', ['user' => factory(User::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_users()
    {
        $this->signIn();
        $user = factory(User::class)->create();
        $this->deleteJson(route('users.destroy', ['user' => $user]))->assertStatus(403);

        $this->postJson(route('users.bulk-destroy', ['items' => []]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_specific_user()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['users.delete'])
        );

        $user = factory(User::class)->create();
        $this->deleteJson(route('users.destroy', ['user' => $user]))->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_users_in_bulk()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['users.delete'])
        );

        $users = factory(User::class, 5)->create();
        $this->assertCount(6, User::all());
        $this->postJson(route('users.bulk-destroy'), ['items' => $users])->assertStatus(200);
        $this->assertCount(1, User::all());
    }
}
