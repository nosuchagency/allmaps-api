<?php

namespace App\Plugins\Contracts;

use App\Plugins\Search\SearchResults;
use Illuminate\Database\Eloquent\Builder;

interface Search
{
    /**
     * @param $payload
     * @param Builder $builder
     *
     * @return SearchResults
     */
    public function search($payload, Builder $builder): SearchResults;
}