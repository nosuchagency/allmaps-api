<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuildingRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'image' => '',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ];

        if ($this->method() === 'POST') {
            $rules['place'] = 'required';
            $rules['place.id'] = 'required|exists:places,id,deleted_at,NULL';
        }

        return $rules;
    }
}
