<?php

namespace Tests\Feature\ContainerBeacons;

use App\Models\Beacon;
use App\Models\Container;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainerBeaconsUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_change_a_beacon_on_a_container()
    {
        $this->putJson(route('container.beacons.update', [
            'container' => factory(Container::class)->create(),
            'beacon' => factory(Beacon::class)->create(),
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_change_a_beacon_on_a_container()
    {
        $this->signIn();

        $this->putJson(route('container.beacons.update', [
            'container' => factory(Container::class)->create(),
            'beacon' => factory(Beacon::class)->create(),
        ]))->assertStatus(403);
    }

    /** @test */
    public function a_guest_cannot_update_beacons()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['containers.update'])
        );

        $beacon = factory(Beacon::class)->create();

        $container = factory(Container::class)->create();
        $container->beacons()->attach(
            $beacon
        );

        $newBeacon = factory(Beacon::class)->create();

        $this->putJson(route('container.beacons.update', [
            'container' => $container,
            'beacon' => $beacon,
        ]), [
            'beacon' => $newBeacon
        ])->assertStatus(200);

        $this->assertTrue($newBeacon->is($container->beacons()->first()));
    }
}
