<?php

namespace App\Filters;

class IndexFilter extends AbstractFilter
{
    protected $filters = [
        'search' => NameFilter::class,
        'category' => CategoryFilter::class,
        'tags' => TagFilter::class
    ];
}