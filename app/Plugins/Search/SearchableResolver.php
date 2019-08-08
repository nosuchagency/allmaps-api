<?php

namespace App\Plugins\Search;

use App\Plugins\Contracts\BasePlugin;
use App\Plugins\Contracts\Search;

class SearchableResolver
{
    /**
     * @param string $variant
     *
     * @return Search
     */
    public function resolve(string $variant): ?Search
    {
        switch ($variant) {
            case 'internal' :
                return new InternalSearch();
            default :
                return $this->instantiatePlugin($variant);
        }
    }

    /**
     * @param string $variant
     *
     * @return Search
     */
    private function instantiatePlugin(string $variant): ?Search
    {
        $class = config('bb.plugins.namespace') . $variant;

        if (!class_exists($class)) {
            return null;
        }

        if (!is_subclass_of($class, BasePlugin::class)) {
            return null;
        }

        return new $class();
    }
}
