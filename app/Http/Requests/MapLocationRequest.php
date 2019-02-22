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
            'coordinates' => '',
            'poi_id' => 'nullable|exists:pois,id,deleted_at,NULL',
            'beacon_id' => 'nullable|exists:beacons,id,deleted_at,NULL',
            'findable_id' => 'nullable|exists:findables,id,deleted_at,NULL'
        ];
    }
}
