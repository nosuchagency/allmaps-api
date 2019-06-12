<?php

namespace App\Filters;

use App\Contracts\AbstractFilter;
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
    ];
}
