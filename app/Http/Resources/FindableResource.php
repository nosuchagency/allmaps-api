<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FindableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'location_type' => 'findable',
            'name' => $this->name,
            'creator' => $this->creator,
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
