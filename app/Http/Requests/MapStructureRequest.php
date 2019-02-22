<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MapStructureRequest extends FormRequest
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
            'coordinates' => 'array',
            'radius' => 'nullable|numeric|min:0',
            'map_component_id' => 'nullable|exists:map_components,id,deleted_at,NULL'
        ];
    }
}
