<?php

namespace Tests\Feature\Places;

use App\Models\Place;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlacesDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_places()
    {
        $this->postJson(route('places.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('places.destroy', ['place' => factory(Place::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_places()
    {
        $this->signIn();
        $place = factory(Place::class)->create();
        $this->deleteJson(route('places.destroy', ['place' => $place]))->assertStatus(403);

        $this->postJson(route('places.bulk-destroy', ['items' => []]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_place()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['places.delete'])
        );

        $place = factory(Place::class)->create();
        $this->deleteJson(route('places.destroy', ['place' => $place]))->assertOk();
        $this->assertSoftDeleted('places', ['id' => $place->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_places_in_bulk()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['places.delete'])
        );

        $places = factory(Place::class, 5)->create();
        $this->assertCount(5, Place::all());
        $this->postJson(route('places.bulk-destroy'), ['items' => $places])->assertOk();
        $this->assertCount(0, Place::all());
    }
}
