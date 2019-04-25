<?php

namespace Tests\Feature\Floors;

use App\Models\Floor;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FloorsReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_floors()
    {
        $floor = factory(Floor::class)->create();

        $this->getJson(route('floors.index'))->assertStatus(401);
        $this->getJson(route('floors.show', ['floor' => $floor]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_floors()
    {
        $this->signIn();

        $this->getJson(route('floors.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_floors()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.read'])
        );

        $this->getJson(route('floors.index'))->assertStatus(200);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_floor()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.read'])
        );

        $floor = factory(Floor::class)->create();

        $this->getJson(route('floors.show', ['floor' => $floor]))->assertStatus(200);
    }
}
