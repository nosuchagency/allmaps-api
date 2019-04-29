<?php

namespace Tests\Feature\Buildings;

use App\Models\Building;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuildingsReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_buildings()
    {
        $building = factory(Building::class)->create();

        $this->getJson(route('buildings.index'))->assertStatus(401);
        $this->getJson(route('buildings.show', ['building' => $building]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_buildings()
    {
        $this->signIn();

        $this->getJson(route('buildings.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_buildings()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['buildings.read'])
        );

        $this->getJson(route('buildings.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_building()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['buildings.read'])
        );

        $building = factory(Building::class)->create();

        $this->getJson(route('buildings.show', ['building' => $building]))->assertOk();
    }
}
