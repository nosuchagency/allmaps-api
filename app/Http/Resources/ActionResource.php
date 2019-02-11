<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActionResource extends JsonResource
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
            'description' => $this->description,
            'subject_type' => class_basename($this->subject_type),
            'subject_name' => $this->subject ? $this->subject->name : '',
            'causer' => $this->causer,
            'date' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
