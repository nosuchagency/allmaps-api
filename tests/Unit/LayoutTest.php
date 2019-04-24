<?php

namespace Tests\Unit;

use App\Models\Layout;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class LayoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_layout_has_tags()
    {
        $layout = factory(Layout::class)->create();
        $this->assertInstanceOf(Collection::class, $layout->tags);
    }

    /** @test */
    public function a_layout_has_templates()
    {
        $layout = factory(Layout::class)->create();
        $this->assertInstanceOf(Collection::class, $layout->templates);
    }

    /** @test */
    public function a_layout_is_soft_deleted()
    {
        $layout = factory(Layout::class)->create();
        $layout->delete();
        $this->assertSoftDeleted('layouts', ['id' => $layout->id]);
    }
}
