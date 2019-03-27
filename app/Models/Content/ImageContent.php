<?php

namespace App\Models\Content;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Builder;

class ImageContent extends Content
{
    use HasImage;

    /**
     * @var string
     */
    protected static $type = 'image';

    const IMAGE_DIRECTORY_PATH = '/uploads/contents';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', self::$type);
        });

        static::creating(function (ImageContent $image) {
            $image->type = self::$type;
        });
    }
}
