<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapStructureResource extends JsonResource
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
            'markers' => $this->markers,
            'radius' => $this->radius,
            'floor' => new FloorResource($this->floor),
            'component' => new MapComponentResource($this->mapComponent),
        ];
    }
}
