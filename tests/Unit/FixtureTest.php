<?php

namespace Tests\Unit;

use App\Models\Fixture;
use App\Models\Location;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class FixtureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_fixture_has_tags()
    {
        $fixture = factory(Fixture::class)->create();
        $this->assertInstanceOf(Collection::class, $fixture->tags);
    }

    /** @test */
    public function a_fixture_has_locations()
    {
        $fixture = factory(Fixture::class)->create();
        $this->assertInstanceOf(Collection::class, $fixture->locations);
    }

    /** @test */
    public function a_fixture_is_soft_deleted()
    {
        $fixture = factory(Fixture::class)->create();
        $fixture->delete();
        $this->assertSoftDeleted('fixtures', ['id' => $fixture->id]);
    }

    /** @test */
    public function it_soft_deletes_related_locations()
    {
        $fixture = factory(Fixture::class)->create();
        $location = factory(Location::class)->create([
            'fixture_id' => $fixture->id
        ]);

        $fixture->delete();

        $this->assertSoftDeleted('locations', ['id' => $location->id]);
    }
}
