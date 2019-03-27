<?php

namespace App\Http\Requests;

use App\Rules\Imageable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PoiRequest extends FormRequest
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
            'type' => [
                'required',
                Rule::in(['image', 'area']),
            ],
            'color' => '',
            'image' => '',
            'category' => '',
            'tags' => 'array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
