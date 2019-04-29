<?php

namespace Tests\Feature\Containers;

use App\Models\Container;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainersDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_containers()
    {
        $this->postJson(route('containers.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('containers.destroy', ['container' => factory(Container::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_containers()
    {
        $this->signIn();
        $container = factory(Container::class)->create();
        $this->deleteJson(route('containers.destroy', ['container' => $container]))->assertStatus(403);

        $this->postJson(route('containers.bulk-destroy', ['items' => []]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_container()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['containers.delete'])
        );

        $container = factory(Container::class)->create();
        $this->deleteJson(route('containers.destroy', ['container' => $container]))->assertOk();
        $this->assertSoftDeleted('containers', ['id' => $container->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_containers_in_bulk()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['containers.delete'])
        );

        $containers = factory(Container::class, 5)->create();
        $this->assertCount(5, Container::all());
        $this->postJson(route('containers.bulk-destroy'), ['items' => $containers])->assertOk();
        $this->assertCount(0, Container::all());
    }
}
