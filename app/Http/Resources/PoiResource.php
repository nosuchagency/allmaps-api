<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PoiResource extends JsonResource
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
            'location_type' => 'poi',
            'name' => $this->name,
            'internal_name' => $this->internal_name,
            'type' => $this->type,
            'color' => $this->color,
            'icon' => $this->getImageUrl(),
            'creator' => $this->creator,
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
