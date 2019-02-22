<?php

namespace App\Observers;

use App\Models\MapLocation;

class MapLocationObserver
{
    /**
     * Handle the map location "creating" event.
     *
     * @param  \App\Models\MapLocation $mapLocation
     *
     * @return void
     */
    public function creating(MapLocation $mapLocation)
    {
        if (!$mapLocation->name) {
            switch ($mapLocation->getType()) {
                case 'beacon' :
                    $mapLocation->name = $mapLocation->beacon->name;
                    break;
                case 'poi' :
                    $mapLocation->name = $mapLocation->poi->name;
                    break;
                case 'findable' :
                    $mapLocation->name = $mapLocation->findable->name;
                    break;
            }
        }
    }
}
