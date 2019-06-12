<?php

namespace Tests\Unit\Models;

use App\Models\Beacon;
use App\Models\Location;
use App\Pivots\BeaconContainer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class BeaconContainerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_beacon_container_have_hits()
    {
        $beaconContainer = factory(BeaconContainer::class)->create();
        $this->assertInstanceOf(Collection::class, $beaconContainer->hits);
    }

    /** @test */
    public function a_beacon_container_have_rules()
    {
        $beaconContainer = factory(BeaconContainer::class)->create();
        $this->assertInstanceOf(Collection::class, $beaconContainer->rules);
    }
}
