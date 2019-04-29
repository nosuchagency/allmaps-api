<?php

namespace Tests\Feature\ContainerBeacons;

use App\Models\Beacon;
use App\Models\Container;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainerBeaconsCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_attach_a_beacon_to_a_container()
    {
        $this->postJson(route('container.beacons.store', [
            'container' => factory(Container::class)->create(),
            'beacon' => factory(Beacon::class)->create(),
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_attach_a_beacon_to_a_container()
    {
        $this->signIn();

        $this->postJson(route('container.beacons.store', [
            'container' => factory(Container::class)->create(),
            'beacon' => factory(Beacon::class)->create(),
        ]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_attach_a_beacon_to_a_container()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['containers.create'])
        );

        $container = factory(Container::class)->create();
        $beacon = factory(Beacon::class)->create();

        $this->postJson(route('container.beacons.store', [
            'container' => $container,
            'beacon' => $beacon,
        ]))->assertOk();

        $this->assertTrue($beacon->is($container->beacons()->first()));
    }
}
