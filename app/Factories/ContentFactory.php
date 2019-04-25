<?php

namespace App\Factories;

use App\Models\Content\Content;
use App\Models\Content\FileContent;
use App\Models\Content\GalleryContent;
use App\Models\Content\ImageContent;
use App\Models\Content\TextContent;
use App\Models\Content\VideoContent;
use App\Models\Content\WebContent;

class ContentFactory
{
    /**
     * @var string
     */
    const FILE = 'file';

    /**
     * @var string
     */
    const GALLERY = 'gallery';

    /**
     * @var string
     */
    const IMAGE = 'image';

    /**
     * @var string
     */
    const TEXT = 'text';

    /**
     * @var string
     */
    const VIDEO = 'video';

    /**
     * @var string
     */
    const WEB = 'web';

    /**
     * @param string $contentType
     *
     * @return Content|null
     */
    public function make(string $contentType): ?Content
    {
        switch ($contentType) {
            case self::FILE :
                return new FileContent();
            case self::GALLERY :
                return new GalleryContent();
            case self::IMAGE :
                return new ImageContent();
            case self::TEXT :
                return new TextContent();
            case self::VIDEO :
                return new VideoContent();
            case self::WEB :
                return new WebContent();
            default :
                return null;
        }
    }
}