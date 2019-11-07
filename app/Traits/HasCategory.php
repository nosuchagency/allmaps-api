<?php

namespace App\Traits;

use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCategory
{
    /**
     * @param mixed $value
     *
     * @return void
     */
    public function setCategoryAttribute($value)
    {
        $this->attributes['category_id'] = is_array($value) ? $value['id'] : $value;
    }

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
