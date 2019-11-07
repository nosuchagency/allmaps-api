<?php

namespace Tests\Unit\Models;

use App\Models\Beacon;
use App\Models\Location;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class BeaconTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_beacon_has_locations()
    {
        $beacon = factory(Beacon::class)->create();
        $this->assertInstanceOf(Collection::class, $beacon->locations);
    }

    /** @test */
    public function a_beacon_has_tags()
    {
        $beacon = factory(Beacon::class)->create();
        $this->assertInstanceOf(Collection::class, $beacon->tags);
    }

    /** @test */
    public function a_beacon_has_containers()
    {
        $beacon = factory(Beacon::class)->create();
        $this->assertInstanceOf(Collection::class, $beacon->containers);
    }

    /** @test */
    public function a_beacon_is_soft_deleted()
    {
        $beacon = factory(Beacon::class)->create();
        $beacon->delete();
        $this->assertSoftDeleted('beacons', ['id' => $beacon->id]);
    }

    /** @test */
    public function it_soft_deletes_related_locations()
    {
        $beacon = factory(Beacon::class)->create();
        $location = factory(Location::class)->create([
            'locatable_id' => $beacon->id,
            'locatable_type' => 'beacon'
        ]);

        $beacon->delete();

        $this->assertSoftDeleted('locations', ['id' => $location->id]);
    }
}
