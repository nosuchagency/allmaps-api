<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'poi_id' => 'required_without_all:findable_id,beacon_id|sometimes|exists:pois,id',
            'findable_id' => 'required_without_all:poi_id,beacon_id|sometimes|exists:findables,id',
            'beacon_id' => 'required_without_all:poi_id,findable_id|sometimes|exists:beacons,id',
            'lat' => 'required',
            'lng' => 'required',
        ];
    }
}
