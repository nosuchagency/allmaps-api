<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Plugins\Search\SearchableResolver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return int
     */
    protected function paginationNumber()
    {
        return intval(config('bb.pagination.number'));
    }

    /**
     * @param $variants
     * @param Builder $query
     *
     * @return Collection
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

    protected function json($data = [], $status = 200, array $headers = [])
    {
        return response()->json($data, $status, $headers, JSON_PRESERVE_ZERO_FRACTION);
    }
}
