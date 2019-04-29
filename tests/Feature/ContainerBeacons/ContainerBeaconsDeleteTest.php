<?php

namespace Tests\Feature\ContainerBeacons;

use App\Models\Beacon;
use App\Models\Container;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainerBeaconsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_detach_a_beacon_from_a_container()
    {
        $container = factory(Container::class)->create();
        $beacon = factory(Beacon::class)->create();
        $container->beacons()->attach($beacon);

        $this->deleteJson(route('container.beacons.destroy', [
            'container' => $container,
            'beacon' => $beacon,
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_detach_a_beacon_from_a_container()
    {
        $this->signIn();
        $container = factory(Container::class)->create();
        $beacon = factory(Beacon::class)->create();
        $container->beacons()->attach($beacon);

        $this->deleteJson(route('container.beacons.destroy', [
            'container' => $container,
            'beacon' => $beacon,
        ]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_detach_a_beacon_from_a_container()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['containers.delete'])
        );

        $container = factory(Container::class)->create();
        $beacon = factory(Beacon::class)->create();
        $container->beacons()->attach($beacon);

        $this->deleteJson(route('container.beacons.destroy', [
            'container' => $container,
            'beacon' => $beacon,
        ]))->assertOk();
    }
}
