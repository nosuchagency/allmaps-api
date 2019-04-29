<?php

namespace Tests\Feature\BeaconContainers;

use App\Models\Beacon;
use App\Models\Container;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BeaconContainersReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_container_attached_to_a_beacon()
    {
        $beacon = factory(Beacon::class)->create();
        $container = factory(Container::class)->create();
        $beacon->containers()->attach($container);

        $this->getJson(route('beacon.containers.show', [
            'beacon' => $beacon,
            'container' => $container,
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_read_beacon_attached_to_a_container()
    {
        $this->signIn();

        $beacon = factory(Beacon::class)->create();
        $container = factory(Container::class)->create();
        $beacon->containers()->attach($container);

        $this->getJson(route('beacon.containers.show', [
            'beacon' => $beacon,
            'container' => $container,
        ]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_read_container_attached_to_a_beacon()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['beacons.read'])
        );

        $beacon = factory(Beacon::class)->create();
        $container = factory(Container::class)->create();
        $beacon->containers()->attach($container);

        $this->getJson(route('beacon.containers.show', [
            'beacon' => $beacon,
            'container' => $container,
        ]))->assertOk();
    }
}
