<?php

namespace Tests\Feature\Skins;

use App\Models\Skin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkinsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_skins()
    {
        $this->postJson(route('skins.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('skins.destroy', ['skin' => factory(Skin::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_skins()
    {
        $this->signIn();
        $skin = factory(Skin::class)->create();
        $this->deleteJson(route('skins.destroy', ['skin' => $skin]))->assertStatus(403);

        $this->postJson(route('skins.bulk-destroy', ['items' => []]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_skin()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['skins.delete'])
        );

        $skin = factory(Skin::class)->create();
        $this->deleteJson(route('skins.destroy', ['skin' => $skin]))->assertOk();
        $this->assertDatabaseMissing('skins', ['id' => $skin->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_beacons_in_bulk()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['skins.delete'])
        );

        $skins = factory(Skin::class, 5)->create();
        $this->assertCount(5, Skin::all());
        $this->postJson(route('skins.bulk-destroy'), ['items' => $skins])->assertOk();
        $this->assertCount(0, Skin::all());
    }
}
