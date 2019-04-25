<?php

namespace Tests\Unit;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Place;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_place()
    {
        $building = factory(Building::class)->create();
        $this->assertInstanceOf(Place::class, $building->place);
    }

    /** @test */
    public function a_building_has_floors()
    {
        $building = factory(Building::class)->create();
        $this->assertInstanceOf(Collection::class, $building->floors);
    }

    /** @test */
    public function a_building_is_soft_deleted()
    {
        $building = factory(Building::class)->create();
        $building->delete();
        $this->assertSoftDeleted('buildings', ['id' => $building->id]);
    }

    /** @test */
    public function it_soft_deletes_related_floors()
    {
        $building = factory(Building::class)->create();
        $floor = factory(Floor::class)->create([
            'building_id' => $building->id
        ]);

        $floor->delete();

        $this->assertSoftDeleted('floors', ['id' => $floor->id]);
    }
}
