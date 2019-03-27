<?php

namespace App\Filters;

use App\Contracts\AbstractFilter;
use App\Filters\Options\CategoryFilter;
use App\Filters\Options\NameFilter;
use App\Filters\Options\TagFilter;
use App\Filters\Options\TypeFilter;

class PoiFilter extends AbstractFilter
{
    /**
     * @var array
     */
    protected $filters = [
        'search' => NameFilter::class,
        'category' => CategoryFilter::class,
        'tags' => TagFilter::class,
        'type' => TypeFilter::class
    ];
}