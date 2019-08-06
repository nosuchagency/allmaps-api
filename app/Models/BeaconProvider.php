<?php

namespace App\Models;

use App\Contracts\BeaconProviderClient;
use App\Factories\BeaconProviderClientFactory;
use App\Services\Beacons\BeaconImporter;
use Illuminate\Database\Eloquent\Model;

class BeaconProvider extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'json',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'meta',
    ];

    /**
     * Get a beacon import for the provider.
     *
     * @return BeaconImporter
     */
    public function importer()
    {
        return new BeaconImporter($this);
    }

    /**
     * Get a provider client for the provider.
     *
     * @return BeaconProviderClient
     */
    public function client()
    {
        return (new BeaconProviderClientFactory())->make($this);
    }
}
