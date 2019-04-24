<?php

namespace Tests\Unit;

use App\Models\Layout;
use App\Models\Template;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class TemplateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_layout()
    {
        $template = factory(Template::class)->create([
            'layout_id' => factory(Layout::class)->create()
        ]);
        $this->assertInstanceOf(Layout::class, $template->layout);
    }

    /** @test */
    public function a_template_has_tags()
    {
        $template = factory(Template::class)->create();
        $this->assertInstanceOf(Collection::class, $template->tags);
    }

    /** @test */
    public function a_template_is_soft_deleted()
    {
        $template  = factory(Template::class)->create();
        $template->delete();
        $this->assertSoftDeleted('templates', ['id' => $template->id]);
    }
}
