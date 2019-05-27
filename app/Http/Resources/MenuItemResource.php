<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $menuable = null;

        $type = $this->menuable_type ?? 'header';

        switch($type) {
            case 'poi' :
                $menuable = new PoiResource($this->menuable);
                break;
            case 'location' :
                $menuable = new LocationResource($this->menuable);
                break;
            case 'tag' :
                $menuable = new TagResource($this->menuable);
                break;
            case 'category' :
                $menuable = new CategoryResource($this->menuable);
                break;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'order' => $this->order,
            'shown' => $this->shown,
            'type' => $type,
            'menuable' => $menuable,
        ];
    }
}
