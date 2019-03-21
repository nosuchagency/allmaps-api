<?php

namespace App\Plugins\Contracts;

use App\Plugins\Search\SearchResults;
use Illuminate\Database\Eloquent\Builder;

abstract class BasePlugin implements Search, Plugin
{
    /**
     * @param $args
     * @param Builder $query
     *
     * @return SearchResults
     */
    public function getLocations($args, Builder $query): SearchResults
    {
        $constraints = [];

        return new SearchResults(
            $query->where($constraints)->get()
        );
    }
}