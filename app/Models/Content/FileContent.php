<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Builder;

class FileContent extends Content
{
    protected static $type = 'file';

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

        static::creating(function (FileContent $file) {
            $file->type = self::$type;
        });
    }
}
