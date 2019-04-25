<?php

namespace Tests\Feature\Floors;

use App\Models\Floor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FloorsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_floors()
    {
        $this->postJson(route('floors.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('floors.destroy', ['floor' => factory(Floor::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_floors()
    {
        $this->signIn();
        $floor = factory(Floor::class)->create();
        $this->deleteJson(route('floors.destroy', ['floor' => $floor]))->assertStatus(403);

        $this->postJson(route('floors.bulk-destroy', ['items' => []]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_specific_floor()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.delete'])
        );

        $floor = factory(Floor::class)->create();
        $this->deleteJson(route('floors.destroy', ['floor' => $floor]))->assertStatus(200);
        $this->assertSoftDeleted('floors', ['id' => $floor->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_floors_in_bulk()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.delete'])
        );

        $floors = factory(Floor::class, 5)->create();
        $this->assertCount(5, Floor::all());
        $this->postJson(route('floors.bulk-destroy'), ['items' => $floors])->assertStatus(200);
        $this->assertCount(0, Floor::all());
    }
}
