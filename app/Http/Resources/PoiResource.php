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
            'name' => $this->name,
            'type' => $this->type,
            'color' => $this->color,
            'image' => $this->getImageUrl(),
            'creator' => $this->creator,
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
