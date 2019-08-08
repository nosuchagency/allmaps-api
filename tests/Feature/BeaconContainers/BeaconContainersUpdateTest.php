<?php

namespace Tests\Feature\BeaconContainers;

use App\Models\Beacon;
use App\Models\Container;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BeaconContainersUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_change_a_container_on_a_beacon()
    {
        $this->putJson(route('beacon.containers.update', [
            'beacon' => factory(Beacon::class)->create(),
            'container' => factory(Container::class)->create(),
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_change_a_container_on_a_beacon()
    {
        $this->signIn();

        $this->putJson(route('beacon.containers.update', [
            'beacon' => factory(Beacon::class)->create(),
            'container' => factory(Container::class)->create(),
        ]))->assertStatus(403);
    }

    /** @test */
    public function a_guest_can_change_a_container_on_a_beacon()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['beacons.update', 'containers.update'])
        );

        $container = factory(Container::class)->create();

        $beacon = factory(Beacon::class)->create();
        $beacon->containers()->attach(
            $container
        );

        $newContainer = factory(Container::class)->create();

        $this->putJson(route('beacon.containers.update', [
            'beacon' => $beacon,
            'container' => $container,
        ]), [
            'container' => $newContainer
        ])->assertStatus(200);

        $this->assertTrue($newContainer->is($beacon->containers()->first()));
    }
}
