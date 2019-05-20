<?php

namespace App\Http\Requests;

use App\ComponentType;
use App\Rules\RequiredIdRule;
use App\Shape;
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
                Rule::in(ComponentType::TYPES),
            ],
            'shape' => [
                'required',
                Rule::in(Shape::SHAPES),
            ],
            'stroke' => 'boolean',
            'color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'weight' => 'integer|min:1',
            'opacity' => 'nullable|numeric|between:0,1',
            'dashed' => 'boolean',
            'dash_pattern' => '',
            'fill' => 'boolean',
            'fill_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'fill_opacity' => 'nullable|numeric|between:0,1',
            'curved' => 'boolean',
            'image' => '',
            'width' => 'nullable|integer|min:0',
            'height' => 'nullable|integer|min:0',
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
