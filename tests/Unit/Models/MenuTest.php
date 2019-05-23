<?php

namespace Tests\Unit\Models;

use App\Models\Menu;
use App\Models\MenuItem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_menu_has_items()
    {
        $menu = factory(Menu::class)->create();
        $this->assertInstanceOf(Collection::class, $menu->items);
    }

    /** @test */
    public function a_menu_is_soft_deleted()
    {
        $menu = factory(Menu::class)->create();
        $menu->delete();
        $this->assertSoftDeleted('menus', ['id' => $menu->id]);
    }

    /** @test */
    public function it_soft_deletes_related_locations()
    {
        $menu = factory(Menu::class)->create();
        $item = factory(MenuItem::class)->create([
            'menu_id' => $menu->id
        ]);

        $menu->delete();

        $this->assertSoftDeleted('menu_items', ['id' => $item->id]);
    }
}
