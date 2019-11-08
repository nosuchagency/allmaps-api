<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RuleResource extends JsonResource
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
            'distance' => $this->distance,
            'weekday' => $this->weekday,
            'discovery_time' => $this->discovery_time,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'time_from' => $this->time_from,
            'time_to' => $this->time_to,
            'time_restricted' => $this->time_restricted,
            'date_restricted' => $this->date_restricted,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
