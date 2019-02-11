<?php

namespace App\Traits;

use App\Models\Category;

trait HasCategory
{
    /**
     * Set the category.
     *
     * @param  mixed $value
     *
     * @return void
     */
    public function setCategoryAttribute($value)
    {
        $this->attributes['category_id'] = is_array($value) ? $value['id'] : $value;
    }

    /**
     * Get the category that owns the beacon
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}