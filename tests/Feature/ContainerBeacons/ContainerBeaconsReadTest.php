<?php

namespace Tests\Feature\ContainerBeacons;

use App\Models\Beacon;
use App\Models\Container;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainerBeaconsReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_beacon_attached_to_a_container()
    {
        $container = factory(Container::class)->create();
        $beacon = factory(Beacon::class)->create();
        $container->beacons()->attach($beacon);

        $this->getJson(route('container.beacons.show', [
            'container' => $container,
            'beacon' => $beacon,
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_read_beacon_attached_to_a_container()
    {
        $this->signIn();

        $container = factory(Container::class)->create();
        $beacon = factory(Beacon::class)->create();
        $container->beacons()->attach($beacon);

        $this->getJson(route('container.beacons.show', [
            'container' => $container,
            'beacon' => $beacon,
        ]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_read_beacon_attached_to_a_container()
    {
        $role = $this->createRoleWithPermissions(['container:read', 'beacon:read']);

        $this->signIn(null, $role);

        $container = factory(Container::class)->create();
        $beacon = factory(Beacon::class)->create();
        $container->beacons()->attach($beacon);

        $this->getJson(route('container.beacons.show', [
            'container' => $container,
            'beacon' => $beacon,
        ]))->assertOk();
    }
}
