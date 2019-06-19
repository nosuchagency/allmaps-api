<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
        $locatable = null;

        switch ($this->locatable_type) {
            case 'poi' :
                $locatable = new PoiResource($this->locatable);
                break;
            case 'beacon' :
                $locatable = new BeaconResource($this->locatable);
                break;
            case 'fixture' :
                $locatable = new FixtureResource($this->locatable);
                break;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'zoom_to' => $this->zoom_to,
            'zoom_from' => $this->zoom_from,
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
            'container' => new ContainerResource($this->container),
            'coordinates' => $this->coordinates,
            'searchables' => SearchableResource::collection($this->getSearchables()),
            'type' => $this->locatable_type,
            'locatable' => $locatable,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->tags)
        ];
    }
}
