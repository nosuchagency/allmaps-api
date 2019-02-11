<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Builder;

class WebContent extends Content
{
    protected static $type = 'web';

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

        static::creating(function (WebContent $web) {
            $web->type = self::$type;
        });
    }
}
