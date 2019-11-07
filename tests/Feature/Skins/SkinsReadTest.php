<?php

namespace Tests\Feature\Skins;

use App\Models\Skin;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkinsReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_skins()
    {
        $skin = factory(Skin::class)->create();

        $this->getJson(route('skins.index'))->assertStatus(401);
        $this->getJson(route('skins.show', ['skin' => $skin]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_skins()
    {
        $this->signIn();

        $this->getJson(route('skins.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_skins()
    {
        $role = $this->createRoleWithPermissions(['skin:read']);

        $this->signIn(null, $role);

        $this->getJson(route('skins.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_skins_paginated()
    {
        $role = $this->createRoleWithPermissions(['skin:read']);

        $this->signIn(null, $role);

        $this->getJson(route('skins.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_skin()
    {
        $role = $this->createRoleWithPermissions(['skin:read']);

        $this->signIn(null, $role);

        $skin = factory(Skin::class)->create();

        $this->getJson(route('skins.show', ['skin' => $skin]))->assertOk();
    }
}
