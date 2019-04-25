<?php

namespace Tests\Unit\Models;

use App\Models\Building;
use App\Models\Place;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class PlaceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_place_has_tags()
    {
        $place = factory(Place::class)->create();
        $this->assertInstanceOf(Collection::class, $place->tags);
    }

    /** @test */
    public function a_place_has_buildings()
    {
        $place = factory(Place::class)->create();
        $this->assertInstanceOf(Collection::class, $place->buildings);
    }

    /** @test */
    public function a_place_is_soft_deleted()
    {
        $place = factory(Place::class)->create();
        $place->delete();
        $this->assertSoftDeleted('places', ['id' => $place->id]);
    }

    /** @test */
    public function it_soft_deletes_related_buildings()
    {
        $place = factory(Place::class)->create();
        $building = factory(Building::class)->create([
            'place_id' => $place->id
        ]);

        $place->delete();

        $this->assertSoftDeleted('buildings', ['id' => $building->id]);
    }
}
