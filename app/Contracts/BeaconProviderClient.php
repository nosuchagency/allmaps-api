<?php


namespace App\Contracts;

use Illuminate\Support\Collection;

interface BeaconProviderClient
{
    /**
     * Determine if the provider credentials are valid.
     *
     * @return bool
     */
    public function valid();

    /**
     * Get all the Beacons
     *
     * @return Collection
     */
    public function getBeacons();
}
