<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MapComponentRequest extends FormRequest
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
            'description' => '',
            'type' => [
                'required',
                Rule::in(['plan', 'wall', 'room', 'decor']),
            ],
            'shape' => [
                'required',
                Rule::in(['polyline', 'polygon', 'rectangle', 'circle', 'image']),
            ],
            'color' => 'required',
            'opacity' => 'numeric|nullable',
            'weight' => 'digits_between:1,10',
            'curved' => 'required|boolean',
            'width' => 'integer|nullable',
            'height' => 'integer|nullable',
            'image' => '',
            'category' => '',
            'tags' => 'array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
