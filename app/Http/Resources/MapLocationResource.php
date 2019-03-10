<?php

namespace App\Http\Resources;

use App\Models\Searchable;
use Illuminate\Http\Resources\Json\JsonResource;

class MapLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->getType(),
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'company' => $this->company,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'zoom_level_to' => $this->zoom_level_to,
            'zoom_level_from' => $this->zoom_level_from,
            'coordinates' => $this->coordinates,
            'poi' => $this->poi ? new PoiResource($this->poi) : null,
            'beacon' => $this->beacon ? new BeaconResource($this->beacon) : null,
            'fixture' => $this->fixture ? new FixtureResource($this->fixture) : null
        ];
    }
}
