<?php

namespace App\Http\Resources;

use App\Models\Findable;
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
            'coordinates' => $this->coordinates,
            'type' => $this->getType(),
            'poi' => $this->poi ? new PoiResource($this->poi) : null,
            'beacon' => $this->beacon ? new BeaconResource($this->beacon) : null,
            'findable' => $this->findable ? new Findable($this->findable) : null
        ];
    }
}
