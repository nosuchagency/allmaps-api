<?php

namespace App\Http\Requests;

use App\Rules\RequiredIdRule;
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
            'menu' => ['nullable', new RequiredIdRule],
            'menu.id' => 'exists:menus,id',
        ];

        if ($this->method() === 'POST') {
            $rules['place'] = 'required';
            $rules['place.id'] = 'required|exists:places,id,deleted_at,NULL';
        } else {
            $rules['place'] = ['nullable', new RequiredIdRule];
            $rules['place.id'] = 'exists:places,id,deleted_at,NULL';
        }

        return $rules;
    }
}
