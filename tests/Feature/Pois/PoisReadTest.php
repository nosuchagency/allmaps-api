<?php

namespace Tests\Feature\Pois;

use App\Models\Poi;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoisReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_pois()
    {
        $poi = factory(Poi::class)->create();

        $this->getJson(route('pois.index'))->assertStatus(401);
        $this->getJson(route('pois.show', ['poi' => $poi]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_pois()
    {
        $this->signIn();

        $this->getJson(route('pois.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_pois()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['pois.read'])
        );

        $this->getJson(route('pois.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_poi()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['pois.read'])
        );

        $poi = factory(Poi::class)->create();

        $this->getJson(route('pois.show', ['poi' => $poi]))->assertOk();
    }
}
