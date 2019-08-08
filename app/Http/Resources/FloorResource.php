<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FloorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'building' => new BuildingResource($this->whenLoaded('building')),
            'place' => new PlaceResource($this->building->place),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'structures' => StructureResource::collection($this->whenLoaded('structures')),
            'locations' => LocationResource::collection($this->whenLoaded('locations'))
        ];
    }
}
