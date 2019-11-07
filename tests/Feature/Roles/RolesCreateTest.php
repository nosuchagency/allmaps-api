<?php

namespace Tests\Feature\Roles;

use App\Models\Role;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_roles()
    {
        $this->postJson(route('roles.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_roles()
    {
        $this->signIn();

        $this->postJson(route('roles.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_roles()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(2, Role::all());
    }

    /** @test */
    public function it_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function permissions_needs_to_be_an_array_of_valid_permission_objects()
    {
        $this->create(['permissions' => 'not-an-array'])->assertJsonValidationErrors('permissions');
        $this->create(['permissions' => ['not-a-valid-permission-object']])->assertJsonValidationErrors('permissions.0.id');
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function create($attributes = [])
    {
        $role = $this->createRoleWithPermissions(['role:create']);

        $this->signIn(null, $role);

        return $this->postJson(route('roles.store'), $this->validFields($attributes));
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
            'permissions' => []
        ], $overrides);
    }
}
