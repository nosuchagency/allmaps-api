<?php

namespace App\Filters;

class TagFilter
{
    public function filter($builder, $value)
    {
        return $builder->whereHas('tags', function ($query) use ($value) {
            $query->whereIn('id', explode(',', $value));
        });
    }
}