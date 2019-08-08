<?php

namespace Tests\Feature\Locations;

use App\Models\Location;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationsReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_locations()
    {
        $location = factory(Location::class)->create();

        $this->getJson(route('locations.index'))->assertStatus(401);
        $this->getJson(route('locations.show', ['location' => $location]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_locations()
    {
        $this->signIn();

        $this->getJson(route('locations.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_locations()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.read'])
        );

        $this->getJson(route('locations.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_locations_paginated()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.read'])
        );

        $this->getJson(route('locations.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_location()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.read'])
        );

        $location = factory(Location::class)->create();

        $this->getJson(route('locations.show', ['locations' => $location]))->assertOk();
    }
}
