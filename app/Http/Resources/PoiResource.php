<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PoiResource extends JsonResource
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
            'type' => $this->type,
            'stroke' => $this->stroke,
            'stroke_type' => $this->stroke_type,
            'stroke_color' => $this->stroke_color,
            'stroke_width' => $this->stroke_width,
            'stroke_opacity' => $this->stroke_opacity,
            'fill' => $this->fill,
            'fill_color' => $this->fill_color,
            'fill_opacity' => $this->fill_opacity,
            'image' => $this->getImageUrl(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
