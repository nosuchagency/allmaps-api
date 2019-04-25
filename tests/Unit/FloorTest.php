<?php

namespace Tests\Unit;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Location;
use App\Models\Structure;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class FloorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_building()
    {
        $floor = factory(Floor::class)->create();
        $this->assertInstanceOf(Building::class, $floor->building);
    }

    /** @test */
    public function a_floor_has_locations()
    {
        $floor = factory(Floor::class)->create();
        $this->assertInstanceOf(Collection::class, $floor->locations);
    }

    /** @test */
    public function a_floor_has_structures()
    {
        $floor = factory(Floor::class)->create();
        $this->assertInstanceOf(Collection::class, $floor->structures);
    }

    /** @test */
    public function a_floor_is_soft_deleted()
    {
        $floor = factory(Floor::class)->create();
        $floor->delete();
        $this->assertSoftDeleted('floors', ['id' => $floor->id]);
    }

    /** @test */
    public function it_soft_deletes_related_structures()
    {
        $floor = factory(Floor::class)->create();
        $structure = factory(Structure::class)->create([
            'floor_id' => $floor->id
        ]);

        $floor->delete();

        $this->assertSoftDeleted('structures', ['id' => $structure->id]);
    }

    /** @test */
    public function it_soft_deletes_related_locations()
    {
        $floor = factory(Floor::class)->create();
        $location = factory(Location::class)->create([
            'floor_id' => $floor->id
        ]);

        $floor->delete();

        $this->assertSoftDeleted('locations', ['id' => $location->id]);
    }
}
