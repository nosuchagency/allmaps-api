<?php

namespace App\Filters\Options;

use App\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class HasLocationsFilter implements FilterInterface
{
    /**
     * @param Builder $builder
     * @param $value
     *
     * @return Builder
     */
    public function filter(Builder $builder, $value): Builder
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);

        if ($value) {
            return $builder->whereHas('locations');
        }

        return $builder->whereDoesntHave('locations');
    }
}