<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FloorResource extends JsonResource
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
            'level' => $this->level,
            'building' => $this->building,
            'place' => $this->building->place,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'creator' => $this->creator,
            'structures' => StructureResource::collection($this->whenLoaded('structures')),
            'locations' => LocationResource::collection($this->whenLoaded('locations'))
        ];
    }
}
