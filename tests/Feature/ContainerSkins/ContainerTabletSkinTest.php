<?php

namespace Tests\Feature\ContainerSkins;

use App\Models\Container;
use App\Models\Skin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainerTabletSkinTest extends TestCase
{
    use RefreshDatabase;

    protected $skinsDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createSkinsDirectory();
    }

    protected function tearDown(): void
    {
        $this->removeSkinsDirectory();

        parent::tearDown();
    }

    /** @test */
    public function it_returns_404_if_container_does_not_have_tablet_skin()
    {
        $skin = factory(Skin::class)->create();
        $this->addDirectory('/' . $skin->identifier);
        $this->addFile('index.html', '/' . $skin->identifier);

        $this->getJson(route('container.players.show', [
            'container' => factory(Container::class)->create([
                'mobile_skin_id' => factory(Skin::class)->create(),
                'desktop_skin_id' => factory(Skin::class)->create()
            ]),
            'type' => 'tablet'
        ]))->assertStatus(404);
    }

    /** @test */
    public function it_returns_200_if_all_required_assets_exist()
    {
        $skin = factory(Skin::class)->create();
        $this->addDirectory('/' . $skin->identifier);
        $this->addFile('index.html', '/' . $skin->identifier);

        $this->getJson(route('container.players.show', [
            'container' => factory(Container::class)->create([
                'tablet_skin_id' => $skin
            ]),
            'type' => 'tablet'
        ]))->assertOk();
    }
}
