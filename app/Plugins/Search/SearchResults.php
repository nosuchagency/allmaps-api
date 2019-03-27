<?php

namespace App\Plugins\Search;

use Illuminate\Support\Collection;

class SearchResults extends Collection
{
    /**
     * SearchResults constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        parent::__construct($items);
    }
}