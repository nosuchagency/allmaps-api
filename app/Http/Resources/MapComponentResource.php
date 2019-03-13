<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapComponentResource extends JsonResource
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
            'description' => $this->description,
            'shape' => $this->shape,
            'color' => $this->color,
            'opacity' => $this->opacity,
            'weight' => $this->weight,
            'curved' => $this->curved,
            'width' => $this->width,
            'height' => $this->height,
            'image' => $this->getImageUrl(),
            'creator' => $this->creator,
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
