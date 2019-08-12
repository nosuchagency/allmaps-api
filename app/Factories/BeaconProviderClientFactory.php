<?php

namespace App\Factories;

use App\Contracts\BeaconProviderClient;
use App\Models\BeaconProvider;
use App\Services\Estimote;
use App\Services\Kontakt;
use InvalidArgumentException;

class BeaconProviderClientFactory
{

    /**
     * @param BeaconProvider $provider
     *
     * @return BeaconProviderClient
     *
     * @throws InvalidArgumentException
     */
    public function make(BeaconProvider $provider): BeaconProviderClient
    {
        switch ($provider->type) {
            case 'kontakt' :
                return new Kontakt($provider);
            case 'estimote' :
                return new Estimote($provider);
            default :
                throw new InvalidArgumentException(
                    "[{$provider->type}] is not a valid provider"
                );
        }
    }
}
