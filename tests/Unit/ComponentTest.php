<?php

namespace Tests\Unit;

use App\Models\Component;
use App\Models\Structure;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class ComponentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_component_has_tags()
    {
        $component = factory(Component::class)->create();
        $this->assertInstanceOf(Collection::class, $component->tags);
    }

    /** @test */
    public function a_component_has_structures()
    {
        $component = factory(Component::class)->create();
        $this->assertInstanceOf(Collection::class, $component->structures);
    }

    /** @test */
    public function a_component_is_soft_deleted()
    {
        $component = factory(Component::class)->create();
        $component->delete();
        $this->assertSoftDeleted('components', ['id' => $component->id]);
    }

    /** @test */
    public function it_soft_deletes_related_structures()
    {
        $component = factory(Component::class)->create();
        $mapStructure = factory(Structure::class)->create([
            'component_id' => $component->id
        ]);

        $component->delete();

        $this->assertSoftDeleted('structures', ['id' => $mapStructure->id]);
    }
}
