<?php

namespace App\Models\Content;

use App\Traits\HasImage;

class ImageContent extends Content
{
    use HasImage;

    /**
     * @var string
     */
    protected static $singleTableType = 'image';

    const IMAGE_DIRECTORY_PATH = '/uploads/contents';
}
