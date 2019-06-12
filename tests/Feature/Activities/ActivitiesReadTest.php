<?php

namespace Tests\Feature\Activities;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivitiesReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_activities()
    {
        $activity = activity()->log('Look mum, I logged something');

        $this->getJson(route('activities.index'))->assertStatus(401);
        $this->getJson(route('activities.show', ['activity' => $activity]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_activities()
    {
        $this->signIn();

        $this->getJson(route('activities.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_activities()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['activities.read'])
        );

        $this->getJson(route('activities.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_activities_paginated()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['activities.read'])
        );

        $this->getJson(route('activities.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_activity()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['activities.read'])
        );

        $activity = activity()->log('Look mum, I logged something');

        $this->getJson(route('activities.show', ['activity' => $activity]))->assertOk();
    }
}
