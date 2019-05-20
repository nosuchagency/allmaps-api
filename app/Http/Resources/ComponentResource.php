<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComponentResource extends JsonResource
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
            'shape' => $this->shape,
            'description' => $this->description,
            'stroke' => $this->stroke,
            'color' => $this->color,
            'weight' => $this->weight,
            'opacity' => $this->opacity,
            'dashed' => $this->dashed,
            'dash_pattern' => $this->dash_pattern,
            'fill' => $this->fill,
            'fill_color' => $this->color,
            'fill_opacity' => $this->fill_opacity,
            'curved' => $this->curved,
            'image' => $this->getImageUrl(),
            'width' => $this->width,
            'height' => $this->height,
            'creator' => $this->creator,
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
