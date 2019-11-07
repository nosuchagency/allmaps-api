<?php

namespace Tests\Feature\Structures;

use App\Models\Structure;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StructuresReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_structures()
    {
        $structure = factory(Structure::class)->create();

        $this->getJson(route('structures.index'))->assertStatus(401);
        $this->getJson(route('structures.show', ['structure' => $structure]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_structures()
    {
        $this->signIn();

        $this->getJson(route('structures.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_structures()
    {
        $role = $this->createRoleWithPermissions(['structure:read']);

        $this->signIn(null, $role);

        $this->getJson(route('structures.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_structures_paginated()
    {
        $role = $this->createRoleWithPermissions(['structure:read']);

        $this->signIn(null, $role);

        $this->getJson(route('structures.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_structure()
    {
        $role = $this->createRoleWithPermissions(['structure:read']);

        $this->signIn(null, $role);

        $structure = factory(Structure::class)->create();

        $this->getJson(route('structures.show', ['structure' => $structure]))->assertOk();
    }
}
