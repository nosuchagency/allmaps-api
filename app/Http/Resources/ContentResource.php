<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
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
            'url' => $this->url,
            'text' => $this->text,
            'yt_url' => $this->yt_url,
            'folder_id' => $this->folder_id,
            'content_id' => $this->content_id,
            'order' => $this->order,
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'created_by' => $this->created_by,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
