<?php

namespace App\Filters;

class SearchFilter extends AbstractFilter
{
    protected $filters = [
        'search' => NameFilter::class
    ];
}