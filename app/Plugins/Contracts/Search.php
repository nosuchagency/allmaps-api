<?php

namespace App\Plugins\Contracts;

use App\Plugins\Search\SearchResults;

interface Search
{
    /**
     * @param $payload
     *
     * @return SearchResults
     */
    public function search($payload): SearchResults;
}