<?php

namespace Tests\Feature\Places;

use App\Models\Place;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlacesReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_places()
    {
        $place = factory(Place::class)->create();

        $this->getJson(route('places.index'))->assertStatus(401);
        $this->getJson(route('places.show', ['place' => $place]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_places()
    {
        $this->signIn();

        $this->getJson(route('places.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_places()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['places.read'])
        );

        $this->getJson(route('places.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_places_paginated()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['places.read'])
        );

        $this->getJson(route('places.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_place()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['places.read'])
        );

        $place = factory(Place::class)->create();

        $this->getJson(route('places.show', ['place' => $place]))->assertOk();
    }
}
