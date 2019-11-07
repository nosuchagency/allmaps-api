<?php

namespace Tests\Feature\BeaconContainers;

use App\Models\Beacon;
use App\Models\Container;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BeaconContainersDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_detach_a_container_from_a_beacon()
    {
        $beacon = factory(Beacon::class)->create();
        $container = factory(Container::class)->create();
        $beacon->containers()->attach($container);

        $this->deleteJson(route('beacon.containers.destroy', [
            'beacon' => $beacon,
            'container' => $container,
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_detach_a_container_from_a_beacon()
    {
        $this->signIn();
        $beacon = factory(Beacon::class)->create();
        $container = factory(Container::class)->create();
        $beacon->containers()->attach($container);

        $this->deleteJson(route('beacon.containers.destroy', [
            'beacon' => $beacon,
            'container' => $container,
        ]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_detach_a_container_from_a_beacon()
    {
        $role = $this->createRoleWithPermissions(['beacon:delete', 'container:delete']);

        $this->signIn(null, $role);

        $beacon = factory(Beacon::class)->create();
        $container = factory(Container::class)->create();
        $beacon->containers()->attach($container);

        $this->deleteJson(route('beacon.containers.destroy', [
            'beacon' => $beacon,
            'container' => $container,
        ]))->assertOk();
    }
}
