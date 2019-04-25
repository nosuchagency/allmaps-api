<?php

namespace App\Http\Requests;

use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComponentRequest extends FormRequest
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
            'color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'opacity' => 'nullable|numeric|between:0,1',
            'weight' => 'integer|min:1|max:10',
            'curved' => 'boolean',
            'width' => 'nullable|integer|min:0',
            'height' => 'nullable|integer|min:0',
            'image' => '',
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
