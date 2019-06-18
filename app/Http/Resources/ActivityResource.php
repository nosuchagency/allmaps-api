<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'description' => $this->description,
            'subject_type' => class_basename($this->subject_type),
            'subject' => $this->subject,
            'causer' => $this->causer,
            'date' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
