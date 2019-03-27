<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    /**
     * @param Builder $builder
     * @param $value
     *
     * @return Builder
     */
    public function filter(Builder $builder, $value): Builder;
}