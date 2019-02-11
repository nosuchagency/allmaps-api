<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
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
            'description' => $this->description,
            'activated' => $this->activated,
            'content' => $this->content,
            'hook' => $this->hook,
            'layout' => new LayoutResource($this->layout),
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
