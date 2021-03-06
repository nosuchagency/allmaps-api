<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResource extends JsonResource
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
            'image' => $this->getImageUrl(),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'place' => new PlaceResource($this->whenLoaded('place')),
            'menu' => new MenuResource($this->whenLoaded('menu')),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'floors' => FloorResource::collection($this->whenLoaded('floors'))
        ];
    }
}
