<?php

namespace Tests\Feature\Beacons;

use App\Models\Beacon;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BeaconsReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_beacons()
    {
        $beacon = factory(Beacon::class)->create();

        $this->getJson(route('beacons.index'))->assertStatus(401);
        $this->getJson(route('beacons.show', ['beacon' => $beacon]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_beacons()
    {
        $this->signIn();

        $this->getJson(route('beacons.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_beacons()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['beacons.read'])
        );

        $this->getJson(route('beacons.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_beacons_paginated()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['beacons.read'])
        );

        $this->getJson(route('beacons.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_beacon()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['beacons.read'])
        );

        $beacon = factory(Beacon::class)->create();

        $this->getJson(route('beacons.show', ['beacon' => $beacon]))->assertOk();
    }
}
