<?php

namespace App\Filters\Options;

use App\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class TagFilter implements FilterInterface
{
    /**
     * @param Builder $builder
     * @param $value
     *
     * @return Builder
     */
    public function filter(Builder $builder, $value): Builder
    {
        return $builder->whereHas('tags', function ($query) use ($value) {
            $query->whereIn('id', explode(',', $value));
        });
    }
}