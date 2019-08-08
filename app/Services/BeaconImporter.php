<?php

namespace App\Services\Beacons;

use App\Models\Beacon;
use App\Models\BeaconProvider;
use App\Models\Import;
use Exception;

class BeaconImporter
{

    /**
     * @var BeaconProvider
     */
    protected $provider;

    /**
     * @var Import
     */
    protected $import;

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @var bool
     */
    protected $status = true;

    /**
     * BeaconImporter constructor.
     *
     * @param BeaconProvider $provider
     */
    public function __construct(BeaconProvider $provider)
    {
        $this->provider = $provider;
        $this->import = new Import();
    }

    /**
     * @param bool $override
     * @param array $attributes
     */
    public function import(bool $override = false, array $attributes = [])
    {
        $this->beforeImport();

        try {
            foreach ($this->provider->client()->getBeacons() as $beacon) {

                $identifier = ['identifier' => $beacon['identifier']];

                $override
                    ? Beacon::updateOrCreate($identifier, array_merge($beacon, $attributes))
                    : Beacon::firstOrCreate($identifier, array_merge($beacon, $attributes));

                $this->count++;
            }
        } catch (Exception $exception) {
            $this->status = false;
            report($exception);
        }

        $this->afterImport();
    }

    /**
     * @return void
     */
    private function beforeImport()
    {
        $this->import->start('beacon');

        activity()
            ->performedOn($this->import)
            ->log('started');

        activity()->disableLogging();
    }

    /**
     * @return void
     */
    private function afterImport()
    {
        $this->import->finish($this->status, $this->count);

        activity()->enableLogging();

        activity()
            ->performedOn($this->import)
            ->log('finished');
    }
}
