<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Searchable;
use App\Plugins\Search\SearchableResolver;
use Illuminate\Http\Response;

class PluginsController extends Controller
{

    /**
     * @var SearchableResolver
     */
    protected $searchableResolver;

    /**
     * PluginsController constructor.
     *
     * @param SearchableResolver $searchableResolver
     */
    public function __construct(SearchableResolver $searchableResolver)
    {
        $this->middleware('permission:plugins.read');

        $this->searchableResolver = $searchableResolver;
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        $plugins = collect(glob(config('bb.plugins.directory') . '*.php'))->map(function ($fileName) {
            $className = basename($fileName, '.php');

            $searchable = Searchable::select('id', 'activated')->whereIdentifier($className)->first();

            $plugin = $this->searchableResolver->resolve($className);

            return [
                'id' => optional($searchable)->id,
                'name' => $plugin->getName(),
                'identifier' => $className,
                'installed' => (bool)$searchable,
                'activated' => (bool)optional($searchable)->activated
            ];
        });

        return $this->json($plugins, Response::HTTP_OK);
    }
}
