<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Searchable;
use Illuminate\Http\Response;

class PluginsController extends Controller
{

    /**
     * PluginsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:plugins.read');
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        $plugins = collect(glob(config('bb.plugins.directory') . '*.php'))->map(function ($fileName) {
            $pluginName = basename($fileName, '.php');

            $searchable = Searchable::select('id', 'activated')->whereName($pluginName)->first();

            return [
                'id' => optional($searchable)->id,
                'name' => $pluginName,
                'installed' => (bool)$searchable,
                'activated' => (bool)optional($searchable)->activated
            ];
        });

        return response()->json($plugins, Response::HTTP_OK);
    }
}
