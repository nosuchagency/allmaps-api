<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Builder;

class TextContent extends Content
{
    protected static $type = 'text';

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

        static::creating(function(TextContent $text) {
            $text->type = self::$type;
        });
    }
}
