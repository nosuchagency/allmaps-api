<?php

namespace Tests\Feature\ContainerLocations;

use App\Models\Container;
use App\Models\Location;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainerLocationsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_unlink_location_from_container()
    {
        $container = factory(Container::class)->create();
        $location = factory(Location::class)->create();

        $container->locations()->save($location);

        $this->assertCount(1, $container->locations()->get());

        $role = $this->createRoleWithPermissions(['container:delete']);

        $this->signIn(null, $role);

        $this->deleteJson(route('containers.locations.destroy', ['container' => $container]), [
            'data' => [
                $container
            ]
        ])->assertOk();

        $this->assertCount(0, $container->locations()->get());

    }
}
