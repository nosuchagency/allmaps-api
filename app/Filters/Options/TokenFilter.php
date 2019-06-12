<?php

namespace App\Filters\Options;

use App\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class TokenFilter implements FilterInterface
{
    /**
     * @param Builder $builder
     * @param $value
     *
     * @return Builder
     */
    public function filter(Builder $builder, $value): Builder
    {
        return $builder->whereCauserType('token')
            ->whereCauserId($value);
    }
}
