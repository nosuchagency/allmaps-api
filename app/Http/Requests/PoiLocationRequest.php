<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PoiLocationRequest extends FormRequest
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
            'poi_id' => 'required|exists:pois,id',
            'lat' => 'required_without:area',
            'lng' => 'required_without:area',
            'area' => 'required_without_all:lat,lng',
            'leaflet_id' => 'required'
        ];
    }
}
