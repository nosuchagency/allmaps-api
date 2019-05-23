<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Location;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Poi;
use App\Models\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_menu()
    {
        $item = factory(MenuItem::class)->create();
        $this->assertInstanceOf(Menu::class, $item->menu);
    }

    /** @test */
    public function a_menu_item_is_soft_deleted()
    {
        $item = factory(MenuItem::class)->create();
        $item->delete();
        $this->assertSoftDeleted('menu_items', ['id' => $item->id]);
    }

    /** @test */
    public function a_menu_item_can_link_to_a_poi()
    {
        $item = factory(MenuItem::class)->create();
        $poi = factory(Poi::class)->create();
        $item->menuable()->associate($poi);
        $this->assertInstanceOf(Poi::class, $item->menuable);
        $this->assertEquals($item->menuable_type, 'poi');
    }

    /** @test */
    public function a_menu_item_can_link_to_a_location()
    {
        $item = factory(MenuItem::class)->create();
        $location = factory(Location::class)->create();
        $item->menuable()->associate($location);
        $this->assertInstanceOf(Location::class, $item->menuable);
        $this->assertEquals($item->menuable_type, 'location');
    }

    /** @test */
    public function a_menu_item_can_link_to_a_tag()
    {
        $item = factory(MenuItem::class)->create();
        $tag = factory(Tag::class)->create();
        $item->menuable()->associate($tag);
        $this->assertInstanceOf(Tag::class, $item->menuable);
        $this->assertEquals($item->menuable_type, 'tag');
    }

    /** @test */
    public function a_menu_item_can_link_to_a_category()
    {
        $item = factory(MenuItem::class)->create();
        $category = factory(Category::class)->create();
        $item->menuable()->associate($category);
        $this->assertInstanceOf(Category::class, $item->menuable);
        $this->assertEquals($item->menuable_type, 'category');
    }
}
