<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeaconResource extends JsonResource
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
            'identifier' => $this->identifier,
            'description' => $this->description,
            'proximity_uuid' => $this->proximity_uuid,
            'major' => $this->major,
            'minor' => $this->minor,
            'namespace' => $this->namespace,
            'instance_id' => $this->instance_id,
            'url' => $this->url,
            'image' => url('/images/bullseye.png'),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'locations' => LocationResource::collection($this->whenLoaded('locations')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'containers' => BeaconContainerResource::collection($this->whenLoaded('containers'))
        ];
    }
}
