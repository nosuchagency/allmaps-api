<?php

namespace Tests\Unit;

use App\Models\Component;
use App\Models\Floor;
use App\Models\Structure;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StructureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_floor()
    {
        $structure = factory(Structure::class)->create();
        $this->assertInstanceOf(Floor::class, $structure->floor);
    }

    /** @test */
    public function it_belongs_to_a_component()
    {
        $structure = factory(Structure::class)->create();
        $this->assertInstanceOf(Component::class, $structure->component);
    }

    /** @test */
    public function a_structure_is_soft_deleted()
    {
        $structure = factory(Structure::class)->create();
        $structure->delete();
        $this->assertSoftDeleted('structures', ['id' => $structure->id]);
    }
}
