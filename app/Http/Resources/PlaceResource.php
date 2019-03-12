<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
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
            'address' => $this->address,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'image' => $this->getImageUrl(),
            'lat' => $this->lat,
            'lng' => $this->lng,
            'activated' => $this->activated,
            'creator' => $this->creator,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'buildings' => BuildingResource::collection($this->whenLoaded('buildings'))
        ];
    }
}
