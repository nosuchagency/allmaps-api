<?php

namespace Tests\Unit;

use App\Models\Container;
use App\Models\Content\FileContent;
use App\Models\Folder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class FolderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_container()
    {
        $folder = factory(Folder::class)->create();
        $this->assertInstanceOf(Container::class, $folder->container);
    }

    /** @test */
    public function a_folder_has_tags()
    {
        $folder = factory(Folder::class)->create();
        $this->assertInstanceOf(Collection::class, $folder->tags);
    }

    /** @test */
    public function a_folder_has_contents()
    {
        $folder = factory(Folder::class)->create();
        $this->assertInstanceOf(Collection::class, $folder->contents);
    }

    /** @test */
    public function a_folder_is_soft_deleted()
    {
        $folder = factory(Folder::class)->create();
        $folder->delete();
        $this->assertSoftDeleted('content_folders', ['id' => $folder->id]);
    }

    /** @test */
    public function it_soft_deletes_related_contents()
    {
        $folder = factory(Folder::class)->create();
        $content = factory(FileContent::class)->create([
            'folder_id' => $folder->id,
            'container_id' => $folder->container_id
        ]);

        $folder->delete();

        $this->assertSoftDeleted('content', ['id' => $content->id]);
    }
}
