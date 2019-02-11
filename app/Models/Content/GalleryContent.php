<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Builder;

class GalleryContent extends Content
{
    protected static $type = 'gallery';

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

        static::creating(function (GalleryContent $gallery) {
            $gallery->type = self::$type;
        });
    }
}
