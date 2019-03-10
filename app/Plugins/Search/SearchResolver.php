<?php

namespace App\Plugins\Search;

use App\Models\Searchable;
use App\Models\MapLocation;
use App\Plugins\Contracts\BasePlugin;
use App\Plugins\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class SearchResolver
{
    /**
     * @param string $variant
     * @param $query
     *
     * @return Search
     */
    public function resolve(string $variant, $query = null): ?Search
    {
        if (!$query) {
            $query = MapLocation::query();
        }

        switch ($variant) {
            case 'internal' :
                return new InternalSearch($query);
            default :
                return $this->instantiatePlugin($variant, $query);
        }
    }

    /**
     * @param string $variant
     * @param Builder $query
     *
     * @return Search
     */
    private function instantiatePlugin(string $variant, Builder $query): ?Search
    {
        $class = config('bb.plugins.namespace') . $variant;

        if (!class_exists($class)) {
            return null;
        }

        if (!is_subclass_of($class, BasePlugin::class)) {
            return null;
        }

        if (!Searchable::whereName($variant)->exists()) {
            return null;
        }

        return new $class($query);
    }
}