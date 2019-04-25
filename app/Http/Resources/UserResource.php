<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'locale' => $this->locale,
            'role' => $this->roles()->first(),
            'category' => new CategoryResource($this->category),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'contents' => ContentResource::collection($this->whenLoaded('contents')),
            'actions' => ActionResource::collection($this->recentActions())
        ];
    }
}
