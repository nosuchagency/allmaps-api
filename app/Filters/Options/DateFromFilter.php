<?php

namespace App\Filters\Options;

use App\Contracts\FilterInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class DateFromFilter implements FilterInterface
{
    /**
     * @param Builder $builder
     * @param $value
     *
     * @return Builder
     */
    public function filter(Builder $builder, $value): Builder
    {
        return $builder->where('created_at', '>=', Carbon::parse($value)->format('Y-m-d H:i:00'));
    }
}
