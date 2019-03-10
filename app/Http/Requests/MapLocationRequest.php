<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MapLocationRequest extends FormRequest
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
            'name' => '',
            'zoom_level_from' => '',
            'zoom_level_to' => '',
            'title' => '',
            'subtitle' => '',
            'description' => '',
            'company' => '',
            'address' => '',
            'city' => '',
            'postal_code' => '',
            'phone' => '',
            'email' => '',
            'coordinates' => '',
            'fields' => 'array',
            'poi_id' => 'nullable|exists:pois,id,deleted_at,NULL',
            'beacon_id' => 'nullable|exists:beacons,id,deleted_at,NULL',
            'fixture_id' => 'nullable|exists:fixtures,id,deleted_at,NULL'
        ];
    }
}
