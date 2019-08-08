<?php

namespace Tests\Unit\Models;

use App\Models\Hit;
use App\Pivots\BeaconContainer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_hit_has_a_related_hittable_model()
    {
        $hit = factory(Hit::class)->create([
            'hittable_id' => factory(BeaconContainer::class)->create()->id,
            'hittable_type' => 'beacon_container'
        ]);

        $this->assertInstanceOf(BeaconContainer::class, $hit->hittable);
    }
}
