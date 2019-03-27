<?php

namespace App\Observers;

use App\Models\MapStructure;

class MapStructureObserver
{
    /**
     * Handle the map structure "creating" event.
     *
     * @param  \App\Models\MapStructure $mapStructure
     *
     * @return void
     */
    public function creating(MapStructure $mapStructure)
    {
        if (!$mapStructure->name) {
            $mapStructure->name = $mapStructure->mapComponent->name;
        }
    }
}
