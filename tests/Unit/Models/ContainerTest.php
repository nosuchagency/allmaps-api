<?php

namespace Tests\Unit\Models;

use App\Models\Container;
use App\Models\Folder;
use App\Models\Skin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class ContainerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_container_has_tags()
    {
        $container = factory(Container::class)->create();
        $this->assertInstanceOf(Collection::class, $container->tags);
    }

    /** @test */
    public function a_container_has_folders()
    {
        $container = factory(Container::class)->create();
        $this->assertInstanceOf(Collection::class, $container->folders);
    }

    /** @test */
    public function a_container_has_beacons()
    {
        $container = factory(Container::class)->create();
        $this->assertInstanceOf(Collection::class, $container->beacons);
    }

    /** @test */
    public function a_container_has_contents_through_folders()
    {
        $container = factory(Container::class)->create();
        $this->assertInstanceOf(Collection::class, $container->contents);
    }

    /** @test */
    public function a_container_is_soft_deleted()
    {
        $container = factory(Container::class)->create();
        $container->delete();
        $this->assertSoftDeleted('containers', ['id' => $container->id]);
    }

    /** @test */
    public function it_has_a_mobile_skin()
    {
        $container = factory(Container::class)->create([
            'mobile_skin_id' => factory(Skin::class)->create()
        ]);

        $this->assertInstanceOf(Skin::class, $container->mobileSkin);
    }

    /** @test */
    public function it_has_a_tablet_skin()
    {
        $container = factory(Container::class)->create([
            'tablet_skin_id' => factory(Skin::class)->create()
        ]);

        $this->assertInstanceOf(Skin::class, $container->tabletSkin);
    }

    /** @test */
    public function it_has_a_desktop_skin()
    {
        $container = factory(Container::class)->create([
            'desktop_skin_id' => factory(Skin::class)->create()
        ]);

        $this->assertInstanceOf(Skin::class, $container->desktopSkin);
    }

    /** @test */
    public function it_soft_deletes_related_folders()
    {
        $container = factory(Container::class)->create();
        $folder = factory(Folder::class)->create([
            'container_id' => $container->id
        ]);

        $container->delete();

        $this->assertSoftDeleted('folders', ['id' => $folder->id]);
    }
}
