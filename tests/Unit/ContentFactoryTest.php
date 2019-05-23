<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Factories\ContentFactory;
use App\Models\Content\FileContent;
use App\Models\Content\GalleryContent;
use App\Models\Content\ImageContent;
use App\Models\Content\TextContent;
use App\Models\Content\VideoContent;
use App\Models\Content\WebContent;

class ContentFactoryTest extends TestCase
{
    /** @test */
    public function it_returns_file_content_if_type_is_file()
    {
        $contentFactory = new ContentFactory();
        $this->assertInstanceOf(FileContent::class, $contentFactory->make('file'));
    }

    /** @test */
    public function it_returns_gallery_content_if_type_is_gallery()
    {
        $contentFactory = new ContentFactory();
        $this->assertInstanceOf(GalleryContent::class, $contentFactory->make('gallery'));
    }

    /** @test */
    public function it_returns_image_content_if_type_is_image()
    {
        $contentFactory = new ContentFactory();
        $this->assertInstanceOf(ImageContent::class, $contentFactory->make('image'));
    }

    /** @test */
    public function it_returns_text_content_if_type_is_text()
    {
        $contentFactory = new ContentFactory();
        $this->assertInstanceOf(TextContent::class, $contentFactory->make('text'));
    }

    /** @test */
    public function it_returns_video_content_if_type_is_video()
    {
        $contentFactory = new ContentFactory();
        $this->assertInstanceOf(VideoContent::class, $contentFactory->make('video'));
    }

    /** @test */
    public function it_returns_web_content_if_type_is_web()
    {
        $contentFactory = new ContentFactory();
        $this->assertInstanceOf(WebContent::class, $contentFactory->make('web'));
    }

    /** @test */
    public function it_returns_null_if_type_is_invalid()
    {
        $contentFactory = new ContentFactory();
        $this->assertNull($contentFactory->make('invalid-type'));
    }
}
