<?php

namespace Tests\Feature\Pois;

use App\Models\Poi;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoisDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_pois()
    {
        $this->postJson(route('pois.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('pois.destroy', ['poi' => factory(Poi::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_pois()
    {
        $this->signIn();
        $poi = factory(Poi::class)->create();
        $this->deleteJson(route('pois.destroy', ['poi' => $poi]))->assertStatus(403);

        $this->postJson(route('pois.bulk-destroy', ['items' => []]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_specific_poi()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['pois.delete'])
        );

        $poi = factory(Poi::class)->create();
        $this->deleteJson(route('pois.destroy', ['poi' => $poi]))->assertStatus(200);
        $this->assertSoftDeleted('pois', ['id' => $poi->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_pois_in_bulk()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['pois.delete'])
        );

        $pois = factory(Poi::class, 5)->create();
        $this->assertCount(5, Poi::all());
        $this->postJson(route('pois.bulk-destroy'), ['items' => $pois])->assertStatus(200);
        $this->assertCount(0, Poi::all());
    }
}
