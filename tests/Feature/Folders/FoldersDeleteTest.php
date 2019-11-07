<?php

namespace Tests\Feature\Folders;

use App\Models\Folder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoldersDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_folders()
    {
        $this->postJson(route('folders.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('folders.destroy', ['folder' => factory(Folder::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_folders()
    {
        $this->signIn();
        $folder = factory(Folder::class)->create();
        $this->deleteJson(route('folders.destroy', ['folder' => $folder]))->assertStatus(403);

        $this->postJson(route('folders.bulk-destroy'), ['items' => []])->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_folder()
    {
        $role = $this->createRoleWithPermissions(['folder:delete']);

        $this->signIn(null, $role);

        $folder = factory(Folder::class)->create();
        $this->deleteJson(route('folders.destroy', ['folder' => $folder]))->assertOk();
        $this->assertSoftDeleted('folders', ['id' => $folder->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_folders_in_bulk()
    {
        $role = $this->createRoleWithPermissions(['folder:delete']);

        $this->signIn(null, $role);

        $folders = factory(Folder::class, 5)->create();
        $this->assertCount(10, Folder::all());
        $this->postJson(route('folders.bulk-destroy'), ['items' => $folders])->assertOk();
        $this->assertCount(5, Folder::all());
    }
}
