<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Builder;

class VideoContent extends Content
{
    protected static $type = 'video';

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

        static::creating(function (VideoContent $video) {
            $video->type = self::$type;
        });
    }
}
