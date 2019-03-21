<?php

namespace App\Http\Controllers;

use App\Plugins\Search\SearchableResolver;
use Illuminate\Database\Eloquent\Builder;

class BaseController extends Controller
{
    /**
     * @param $variants
     * @param Builder $query
     *
     * @return \Illuminate\Support\Collection
     */
    protected function searchForLocations($variants, Builder $query = null)
    {
        $locations = collect();

        foreach ($variants as $variant => $payload) {
            $searcher = (new SearchableResolver())->resolve($variant);

            if ($searcher) {
                $locations = $locations->merge($searcher->search($payload, $query));
            }
        }

        return $locations->unique();
    }
}
