<?php

namespace App\Http\Requests;

use App\ComponentType;
use App\Models\Component;
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
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Component::class);
        }

        return $this->user()->can('update', Component::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'description' => ['max:65535'],
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
            'stroke_width' => 'integer|min:1|max:4294967295',
            'stroke_opacity' => 'nullable|numeric|between:0,1',
            'fill' => 'boolean',
            'fill_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'fill_opacity' => 'nullable|numeric|between:0,1',
            'image' => '',
            'image_width' => 'nullable|integer|min:0|max:4294967295',
            'image_height' => 'nullable|integer|min:0|max:4294967295',
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => ['exists:categories,id'],
            'tags' => ['array'],
            'tags.*.id' => ['required', 'exists:tags,id']
        ];
    }
}
