<?php

namespace Tests\Feature\ContainerSkins;

use App\Models\Container;
use App\Models\Skin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainerDefaultSkinTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
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
    public function it_returns_404_if_container_does_not_exist()
    {
        $this->getJson(route('container.players.show', [
            'container' => 1
        ]))->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_if_container_does_not_have_mobile_default_skin()
    {
        $skin = factory(Skin::class)->create();
        $this->addDirectory('/' . $skin->identifier);
        $this->addFile('index.html', '/' . $skin->identifier);

        $this->getJson(route('container.players.show', [
            'container' => factory(Container::class)->create()
        ]))->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_if_index_path_does_not_exist()
    {
        $this->getJson(route('container.players.show', [
            'container' => factory(Container::class)->create()
        ]))->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_if_data_key_does_not_exist_in_index_file()
    {
        $this->withoutExceptionHandling();

        $skin = factory(Skin::class)->create();
        $this->addDirectory('/' . $skin->identifier);
        $this->addFile('index-without-data-key.html', '/' . $skin->identifier);

        $this->getJson(route('container.players.show', [
            'container' => factory(Container::class)->create([
                'mobile_skin_id' => factory(Skin::class)->create()
            ])
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
                'mobile_skin_id' => $skin
            ])
        ]))->assertOk();
    }
}
