<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContainerResource extends JsonResource
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
            'description' => $this->description,
            'folders_enabled' => $this->folders_enabled,
            'mobile_skin' => new SkinResource($this->mobileSkin),
            'tablet_skin' => new SkinResource($this->tabletSkin),
            'desktop_skin' => new SkinResource($this->desktopSkin),
            'primary_folder' => new FolderResource($this->primaryFolder()),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'locations' => LocationResource::collection($this->whenLoaded('locations')),
            'contents' => ContentResource::collection($this->whenLoaded('contents')),
            'folders' => FolderResource::collection($this->whenLoaded('folders')),
            'beacons' => ContainerBeaconResource::collection($this->whenLoaded('beacons'))
        ];
    }
}
