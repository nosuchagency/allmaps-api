<?php

namespace App\Http\Requests;

use App\ContentType;
use App\Models\Content\Content;
use App\Rules\FileExists;
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
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Content::class);
        }

        return $this->user()->can('update', Content::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'order' => 'nullable|integer',
            'text' => '',
            'image' => '',
            'file' => ['nullable', new FileExists()],
            'yt_url' => 'nullable|url',
            'url' => 'nullable|url',
            'type' => [
                'required',
                Rule::in(ContentType::TYPES),
            ],
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => ['exists:categories,id'],
            'tags' => ['array'],
            'tags.*.id' => ['required', 'exists:tags,id']
        ];

        if ($this->method() === 'POST') {
            $rules['folder'] = 'required';
            $rules['folder.id'] = 'required|exists:folders,id,deleted_at,NULL';
        } else {
            $rules['folder'] = ['nullable', new RequiredIdRule];
            $rules['folder.id'] = 'exists:folders,id,deleted_at,NULL';
        }

        return $rules;
    }
}
