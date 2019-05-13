<?php

namespace App\Http\Requests;

use App\ContentTypes;
use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContentRequest extends FormRequest
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
            'order' => 'nullable|integer',
            'text' => '',
            'image' => '',
            'yt_url' => 'nullable|url',
            'url' => 'nullable|url',
            'type' => [
                'required',
                Rule::in(ContentTypes::TYPES),
            ],
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*.id' => 'required|exists:tags,id'
        ];

        if ($this->method() === 'POST') {
            $rules['folder'] = 'required';
            $rules['folder.id'] = 'required|exists:folders,id,deleted_at,NULL';
        }

        return $rules;
    }
}
