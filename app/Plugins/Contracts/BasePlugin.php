<?php

namespace App\Plugins\Contracts;

use App\Plugins\Search\SearchResults;
use Illuminate\Database\Eloquent\Builder;

abstract class BasePlugin implements Search, Plugin
{

    /**
     * @var Builder
     */
    protected $query;

    /**
     * BasePlugin constructor.
     *
     * @param Builder $query
     */
    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    /**
     * @param $args
     *
     * @return SearchResults
     */
    public function getLocations($args): SearchResults
    {
        $constraints = [];

        return new SearchResults(
            $this->query->where($constraints)->get()
        );
    }
}