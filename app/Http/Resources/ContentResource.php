<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
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
            'image' => $this->getImageUrl(),
            'file' => $this->getFileUrl(),
            'url' => $this->url,
            'text' => $this->text,
            'yt_url' => $this->yt_url,
            'folder_id' => $this->folder_id,
            'content_id' => $this->content_id,
            'contents' => $this->contents,
            'order' => $this->order,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->tags),
        ];
    }
}
