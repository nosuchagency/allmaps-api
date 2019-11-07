<?php

namespace Tests\Feature\BeaconContainers;

use App\Models\Beacon;
use App\Models\Container;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BeaconContainersCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_attach_a_container_to_a_beacon()
    {
        $this->postJson(route('beacon.containers.store', [
            'beacon' => factory(Beacon::class)->create(),
            'container' => factory(Container::class)->create(),
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_attach_a_container_to_a_beacon()
    {
        $this->signIn();

        $this->postJson(route('beacon.containers.store', [
            'beacon' => factory(Beacon::class)->create(),
            'container' => factory(Container::class)->create(),
        ]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_attach_a_beacon_to_a_container()
    {
        $role = $this->createRoleWithPermissions(['beacon:create', 'container:create']);

        $this->signIn(null, $role);

        $container = factory(Container::class)->create();
        $beacon = factory(Beacon::class)->create();

        $this->postJson(route('beacon.containers.store', [
            'beacon' => $beacon,
            'container' => $container,
        ]))->assertOk();

        $this->assertTrue($container->is($beacon->containers()->first()));
    }
}
