<?php

namespace App\Filters;

use App\Contracts\AbstractFilter;
use App\Filters\Options\NameFilter;

class SearchFilter extends AbstractFilter
{
    /**
     * @var array
     */
    protected $filters = [
        'search' => NameFilter::class
    ];
}