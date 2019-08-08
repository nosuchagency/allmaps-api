<?php

namespace App\Filters\Options;

use App\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class FinishedFilter implements FilterInterface
{
    /**
     * @param Builder $builder
     * @param $value
     *
     * @return Builder
     */
    public function filter(Builder $builder, $value): Builder
    {
        if (!$value || $value === 'false') {
            return $builder->whereNull('finished_at');
        }

        return $builder->whereNotNull('finished_at');
    }
}
