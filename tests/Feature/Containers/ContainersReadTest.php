<?php

namespace Tests\Feature\Containers;

use App\Models\Container;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainersReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_containers()
    {
        $container = factory(Container::class)->create();

        $this->getJson(route('containers.index'))->assertStatus(401);
        $this->getJson(route('containers.show', ['container' => $container]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_containers()
    {
        $this->signIn();

        $this->getJson(route('containers.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_containers()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['containers.read'])
        );

        $this->getJson(route('containers.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_container()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['containers.read'])
        );

        $container = factory(Container::class)->create();

        $this->getJson(route('containers.show', ['container' => $container]))->assertOk();
    }
}
