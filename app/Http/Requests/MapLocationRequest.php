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
            'zoom_from' => 'integer|min:0',
            'zoom_to' => 'integer|min:0',
            'title' => '',
            'subtitle' => '',
            'image' => '',
            'description' => '',
            'contact_name' => '',
            'company' => '',
            'address' => '',
            'city' => '',
            'postcode' => '',
            'phone' => '',
            'email' => 'email|nullable',
            'search_activated' => 'boolean',
            'search_text' => '',
            'activated_at' => 'date|nullable',
            'publish_at' => 'date|nullable',
            'unpublish_at' => 'date|nullable',
            'coordinates' => 'array|nullable',
            'fields' => 'array',
            'poi_id' => 'nullable|exists:pois,id,deleted_at,NULL',
            'beacon_id' => 'nullable|exists:beacons,id,deleted_at,NULL',
            'fixture_id' => 'nullable|exists:fixtures,id,deleted_at,NULL'
        ];
    }
}
