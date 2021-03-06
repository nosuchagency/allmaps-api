<?php

namespace Tests\Feature\Folders;

use App\Models\Folder;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoldersReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_folders()
    {
        $folder = factory(Folder::class)->create();

        $this->getJson(route('folders.index'))->assertStatus(401);
        $this->getJson(route('folders.show', ['folder' => $folder]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_folders()
    {
        $this->signIn();

        $this->getJson(route('folders.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_folders()
    {
        $role = $this->createRoleWithPermissions(['folder:read']);

        $this->signIn(null, $role);

        $this->getJson(route('folders.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_folders_paginated()
    {
        $role = $this->createRoleWithPermissions(['folder:read']);

        $this->signIn(null, $role);

        $this->getJson(route('folders.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_folder()
    {
        $role = $this->createRoleWithPermissions(['folder:read']);

        $this->signIn(null, $role);

        $folder = factory(Folder::class)->create();

        $this->getJson(route('folders.show', ['folder' => $folder]))->assertOk();
    }
}
