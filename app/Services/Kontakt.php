<?php

namespace App\Services;

use App\Contracts\BeaconProviderClient;
use App\Models\BeaconProvider;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Kontakt implements BeaconProviderClient
{

    /**
     * The server provider instance.
     *
     * @var BeaconProvider
     */
    protected $provider;

    /**
     * Kontakt constructor.
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
            $this->request('get', '/activity');

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
        $result = $this->request('get', '/device');

        return collect($result->devices)->map(function ($device) {
            return $this->getBeacon($device);
        });
    }

    /**
     * @param $device
     *
     * @return array
     */
    public function getBeacon($device)
    {
        $url = ltrim(hex2bin($device->url), '');

        return [
            'name' => $device->uniqueId,
            'identifier' => $device->uniqueId,
            'proximity_uuid' => $device->proximity,
            'major' => $device->major,
            'minor' => $device->minor,
            'namespace' => $device->namespace,
            'instance_id' => $device->instanceId,
            'url' => parse_url($url, PHP_URL_SCHEME) === null ? 'https://' . $url : $url
        ];
    }

    /**
     * Make an HTTP request to Kontakt.
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
            'Content-Type' => 'application/json',
            'headers' => [
                'Accept' => 'application/vnd.com.kontakt+json;version=10',
                'Api-Key' => $this->provider->meta['api_key'],
                'User-Agent' => 'AllMaps'
            ],
            'json' => $parameters,
        ]);

        return json_decode((string)$response->getBody());
    }

    /**
     * Get the Kontakt api url
     *
     * @return string
     */
    protected function getUrl()
    {
        return config('services.kontakt.url');
    }
}
