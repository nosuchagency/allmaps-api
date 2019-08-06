<?php

namespace App\Filters;

use App\Contracts\AbstractFilter;
use App\Filters\Options\FinishedFilter;
use App\Filters\Options\TypeFilter;

class ImportFilter extends AbstractFilter
{
    /**
     * @var array
     */
    protected $filters = [
        'type' => TypeFilter::class,
        'finished' => FinishedFilter::class
    ];
}
