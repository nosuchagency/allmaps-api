<?php

namespace App\Http\Resources;

use App\Models\Searchable;
use Illuminate\Http\Resources\Json\JsonResource;

class MapLocationResource extends JsonResource
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
            'zoom_to' => $this->zoom_to,
            'zoom_from' => $this->zoom_from,
            'type' => $this->getType(),
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'image' => $this->getImageUrl(),
            'description' => $this->description,
            'contact_name' => $this->contact_name,
            'company' => $this->company,
            'address' => $this->address,
            'city' => $this->city,
            'postcode' => $this->postcode,
            'phone' => $this->phone,
            'email' => $this->email,
            'search_activated' => $this->search_activated,
            'search_text' => $this->search_text,
            'monday_from' => $this->monday_from,
            'monday_to' => $this->monday_to,
            'tuesday_from' => $this->tuesday_from,
            'tuesday_to' => $this->tuesday_to,
            'wednesday_from' => $this->wednesday_from,
            'wednesday_to' => $this->wednesday_to,
            'thursday_from' => $this->thursday_from,
            'thursday_to' => $this->thursday_to,
            'friday_from' => $this->friday_from,
            'friday_to' => $this->friday_to,
            'saturday_from' => $this->saturday_from,
            'saturday_to' => $this->saturday_to,
            'sunday_from' => $this->sunday_from,
            'sunday_to' => $this->sunday_to,
            'activated_at' => $this->activated_at,
            'publish_at' => $this->publish_at,
            'unpublish_at' => $this->unpublish_at,
            'coordinates' => $this->coordinates,
            'poi' => $this->poi ? new PoiResource($this->poi) : null,
            'beacon' => $this->beacon ? new BeaconResource($this->beacon) : null,
            'fixture' => $this->fixture ? new FixtureResource($this->fixture) : null
        ];
    }
}
