<?php

namespace Tests\Feature\Activities;

use App\Models\Import;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportsReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_activities()
    {
        $import = factory(Import::class)->create();

        $this->getJson(route('imports.index'))->assertStatus(401);
        $this->getJson(route('imports.show', ['import' => $import]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_import()
    {
        $this->signIn();

        $this->getJson(route('imports.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_imports()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['imports.read'])
        );

        $this->getJson(route('imports.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_activities_paginated()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['imports.read'])
        );

        $this->getJson(route('imports.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_import()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['imports.read'])
        );

        $import = factory(Import::class)->create();

        $this->getJson(route('imports.show', ['import' => $import]))->assertOk();
    }
}
