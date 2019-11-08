<?php

namespace App\Http\Requests;

use App\Models\Poi;
use App\PoiType;
use App\Rules\RequiredIdRule;
use App\StrokeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class  PoiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Poi::class);
        }

        return $this->user()->can('update', Poi::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() === 'POST') {
            return $this->rulesForCreating();
        }

        return $this->rulesForUpdating();
    }

    /**
     * @return array
     */
    public function rulesForCreating()
    {
        return [
            'name' => ['required', 'max:255'],
            'type' => [
                'required',
                Rule::in(PoiType::TYPES),
            ],
            'stroke' => ['boolean'],
            'stroke_type' => [
                'required',
                Rule::in(StrokeType::TYPES),
            ],
            'stroke_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'stroke_width' => ['integer', 'min:1', 'max:4294967295'],
            'stroke_opacity' => ['nullable', 'numeric', 'between:0,1'],
            'fill' => ['boolean'],
            'fill_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'fill_opacity' => ['nullable', 'numeric', 'between:0,1'],
            'image' => [],
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => ['exists:categories,id'],
            'tags' => ['array'],
            'tags.*.id' => ['required', 'exists:tags,id']
        ];
    }

    /**
     * @return array
     */
    public function rulesForUpdating()
    {
        return [
            'name' => ['filled', 'max:255'],
            'type' => [
                'filled',
                Rule::in(PoiType::TYPES),
            ],
            'stroke' => ['boolean'],
            'stroke_type' => [
                'filled',
                Rule::in(StrokeType::TYPES),
            ],
            'stroke_color' => ['filled', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'stroke_width' => ['integer', 'min:1', 'max:4294967295'],
            'stroke_opacity' => ['nullable', 'numeric', 'between:0,1'],
            'fill' => ['boolean'],
            'fill_color' => ['filled', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'fill_opacity' => ['nullable', 'numeric', 'between:0,1'],
            'image' => '',
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => ['exists:categories,id'],
            'tags' => ['array'],
            'tags.*.id' => ['required', 'exists:tags,id']
        ];
    }
}
