<?php

namespace App\Http\Controllers;

use App\Plugins\Search\SearchResolver;
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
            $searcher = (new SearchResolver())->resolve($variant, $query);

            if ($searcher) {
                $locations = $locations->merge($searcher->search($payload));
            }
        }

        return $locations->unique();
    }
}
