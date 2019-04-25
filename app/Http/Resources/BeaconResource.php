<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BeaconResource extends JsonResource
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
            'image' => url('/img/bullseye.png'),
            'name' => $this->name,
            'description' => $this->description,
            'proximity_uuid' => $this->proximity_uuid,
            'major' => $this->major,
            'minor' => $this->minor,
            'eddystone_uid' => $this->eddystone_uid,
            'eddystone_url' => $this->eddystone_url,
            'eddystone_tlm' => $this->eddystone_tlm,
            'eddystone_eid' => $this->eddystone_eid,
            'creator' => $this->creator,
            'category' => new CategoryResource($this->category),
            'locations' => LocationResource::collection($this->whenLoaded('locations')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'containers' => BeaconContainerResource::collection($this->whenLoaded('containers'))
        ];
    }
}
