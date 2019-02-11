<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BeaconLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location_type' => 'beacon',
            'lat' => $this->lat,
            'lng' => $this->lng,
            'leaflet_id' => $request->get('leaflet_id'),
            'creator' => $this->creator
        ];
    }
}
