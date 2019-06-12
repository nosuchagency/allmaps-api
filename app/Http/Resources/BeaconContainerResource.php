<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeaconContainerResource extends JsonResource
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
            'hits' => $this->whenPivotLoaded('beacon_container', function () {
                return $this->pivot->hits;
            }),
            'rules' => $this->whenPivotLoaded('beacon_container', function () {
                return RuleResource::collection($this->pivot->rules);
            })
        ];
    }
}
