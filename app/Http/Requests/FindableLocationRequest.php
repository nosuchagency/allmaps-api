<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindableLocationRequest extends FormRequest
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
            'findable_id' => 'required|exists:findables,id',
            'lat' => 'required',
            'lng' => 'required',
            'leaflet_id' => 'required'
        ];
    }
}
