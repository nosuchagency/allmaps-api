<?php

namespace Tests\Feature\Locations;

use App\Models\Location;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_locations()
    {
        $this->postJson(route('locations.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('locations.destroy', ['location' => factory(Location::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_locations()
    {
        $this->signIn();
        $location = factory(Location::class)->create();
        $this->deleteJson(route('locations.destroy', ['location' => $location]))->assertStatus(403);

        $this->postJson(route('locations.bulk-destroy', ['items' => []]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_specific_location()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.delete'])
        );

        $location = factory(Location::class)->create();
        $this->deleteJson(route('locations.destroy', ['location' => $location]))->assertStatus(200);
        $this->assertSoftDeleted('locations', ['id' => $location->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_locations_in_bulk()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.delete'])
        );

        $locations = factory(Location::class, 5)->create();
        $this->assertCount(5, Location::all());
        $this->postJson(route('locations.bulk-destroy'), ['items' => $locations])->assertStatus(200);
        $this->assertCount(0, Location::all());
    }
}
