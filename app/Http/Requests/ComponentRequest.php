<?php

namespace App\Http\Requests;

use App\ComponentType;
use App\Rules\RequiredIdRule;
use App\Shape;
use App\StrokeType;
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
            'stroke_type' => [
                'required',
                Rule::in(StrokeType::TYPES),
            ],
            'stroke_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'stroke_width' => 'integer|min:1',
            'stroke_opacity' => 'nullable|numeric|between:0,1',
            'fill' => 'boolean',
            'fill_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'fill_opacity' => 'nullable|numeric|between:0,1',
            'image' => '',
            'image_width' => 'nullable|integer|min:0',
            'image_height' => 'nullable|integer|min:0',
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
