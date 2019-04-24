<?php

namespace Tests\Unit;

use App\Models\Beacon;
use App\Models\Fixture;
use App\Models\Floor;
use App\Models\Location;
use App\Models\Poi;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_floor()
    {
        $location = factory(Location::class)->create();
        $this->assertInstanceOf(Floor::class, $location->floor);
    }

    /** @test */
    public function it_belongs_to_a_poi()
    {
        $location = factory(Location::class)->create([
            'poi_id' => factory(Poi::class)->create()
        ]);
        $this->assertInstanceOf(Poi::class, $location->poi);

        $this->assertEquals('poi', $location->getType());
    }

    /** @test */
    public function it_belongs_to_a_fixture()
    {
        $location = factory(Location::class)->create([
            'fixture_id' => factory(Fixture::class)->create()
        ]);
        $this->assertInstanceOf(Fixture::class, $location->fixture);

        $this->assertEquals('fixture', $location->getType());
    }

    /** @test */
    public function it_belongs_to_a_beacon()
    {
        $location = factory(Location::class)->create([
            'beacon_id' => factory(Beacon::class)->create()
        ]);
        $this->assertInstanceOf(Beacon::class, $location->beacon);

        $this->assertEquals('beacon', $location->getType());
    }

    /** @test */
    public function a_location_is_soft_deleted()
    {
        $location = factory(Location::class)->create();
        $location->delete();
        $this->assertSoftDeleted('locations', ['id' => $location->id]);
    }
}
