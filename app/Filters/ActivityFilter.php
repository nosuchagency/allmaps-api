<?php

namespace App\Filters;

use App\Contracts\AbstractFilter;
use App\Filters\Options\DateFromFilter;
use App\Filters\Options\DateToFilter;
use App\Filters\Options\TokenFilter;
use App\Filters\Options\UserFilter;

class ActivityFilter extends AbstractFilter
{
    /**
     * @var array
     */
    protected $filters = [
        'user' => UserFilter::class,
        'token' => TokenFilter::class,
        'date_from' => DateFromFilter::class,
        'date_to' => DateToFilter::class,
    ];
}
