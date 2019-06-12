<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hit extends Model
{
    use SoftDeletes;

    /**
     * Get the related model that has been hit
     */
    public function hittable()
    {
        return $this->morphTo();
    }

}
