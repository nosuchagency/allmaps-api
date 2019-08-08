<?php

namespace App\Services;

use App\Contracts\BeaconProviderClient;
use App\Models\BeaconProvider;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Estimote implements BeaconProviderClient
{

    /**
     * The server provider instance.
     *
     * @var BeaconProvider
     */
    protected $provider;

    /**
     * Estimote constructor.
     *
     * @param BeaconProvider $provider
     *
     * @return void
     */
    public function __construct(BeaconProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Determine if the provider credentials are valid.
     *
     * @return bool
     */
    public function valid()
    {
        try {
            $this->request('get', '/devices');

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get all the Beacons
     *
     * @return Collection
     */
    public function getBeacons()
    {
        $beacons = $this->aggregate('get', '/devices', 'data');

        return collect($beacons)->map(function ($device) {
            return $this->getBeacon($device);
        });
    }

    /**
     * @param $device
     *
     * @return array
     */
    public function getBeacon(object $device)
    {
        return [
            'name' => $device->identifier,
            'identifier' => $device->identifier,
            'proximity_uuid' => $device->settings->advertisers->ibeacon[0]->uuid,
            'major' => $device->settings->advertisers->ibeacon[0]->major,
            'minor' => $device->settings->advertisers->ibeacon[0]->minor,
            'namespace' => $device->settings->advertisers->eddystone_uid[0]->namespace_id,
            'instance_id' => $device->settings->advertisers->eddystone_uid[0]->instance_id,
            'url' => $device->settings->advertisers->eddystone_url[0]->url,
        ];
    }

    /**
     * Make an HTTP request to Estimote.
     *
     * @param string $method
     * @param string $path
     * @param array $parameters
     *
     * @return object
     */
    protected function request($method, $path, array $parameters = [])
    {
        $response = (new Client)->{$method}($this->getUrl() . ltrim($path, '/'), [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'auth' => [$this->provider->meta['app_id'], $this->provider->meta['app_token']],
            'json' => $parameters,
        ]);

        return json_decode((string)$response->getBody());
    }

    /**
     * Aggregate pages of results into a single result array.
     *
     * @param string $method
     * @param string $path
     * @param string $target
     * @param array $parameters
     *
     * @return array
     */
    protected function aggregate($method, $path, $target, array $parameters = [])
    {
        $page = 1;

        $results = [];

        do {
            $response = $this->request(
                $method, $path . '?page=' . $page . '&device_type=beacon', $parameters
            );

            $results = array_merge($results, $response[$target]);

            $page++;
        } while ($response->meta->page < intval(ceil($response->meta->total_count / 100)));

        return $results;
    }

    /**
     * Get the Estimote api url
     *
     * @return string
     */
    protected function getUrl()
    {
        return config('services.estimote.url');
    }
}
