<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceRequest extends FormRequest
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
            'name' => 'required',
            'address' => '',
            'postcode' => 'numeric|nullable',
            'city' => '',
            'image' => '',
            'lat' => 'required',
            'lng' => 'required',
            'activated' => 'boolean',
            'category' => '',
            'tags' => 'present|array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
