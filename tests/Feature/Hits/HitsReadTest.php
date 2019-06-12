<?php

namespace Tests\Feature\Hits;

use App\Models\Hit;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HitsReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_hits()
    {
        $hit = factory(Hit::class)->create();

        $this->getJson(route('hits.index'))->assertStatus(401);
        $this->getJson(route('hits.show', ['hit' => $hit]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_hits()
    {
        $this->signIn();

        $this->getJson(route('hits.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_hits()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['hits.read'])
        );

        $this->getJson(route('hits.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_hits_paginated()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['hits.read'])
        );

        $this->getJson(route('hits.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_hit()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['hits.read'])
        );

        $hit = factory(Hit::class)->create();

        $this->getJson(route('hits.show', ['hit' => $hit]))->assertOk();
    }
}
