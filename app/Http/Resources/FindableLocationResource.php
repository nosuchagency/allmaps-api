<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FindableLocationResource extends JsonResource
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
            'location_type' => 'findable',
            'lat' => $this->lat,
            'lng' => $this->lng,
            'findable' => $this->findable,
            'leaflet_id' => $request->get('leaflet_id'),
            'creator' => $this->creator
        ];
    }
}
