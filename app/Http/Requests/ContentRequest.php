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
            'order' => ['nullable', 'integer', 'max:4294967295'],
            'text' => [],
            'image' => [],
            'file' => ['nullable', new FileExists()],
            'yt_url' => ['nullable', 'url'],
            'url' => ['nullable', 'url'],
            'type' => [
                'required',
                Rule::in(ContentType::TYPES),
            ],
            'folder' => ['required'],
            'folder.id' => ['required', 'exists:folders,id'],
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
            'order' => ['nullable', 'integer', 'max:4294967295'],
            'text' => [],
            'image' => [],
            'file' => ['nullable', new FileExists()],
            'yt_url' => ['nullable', 'url'],
            'url' => ['nullable', 'url'],
            'type' => [
                'filled',
                Rule::in(ContentType::TYPES),
            ],
            'folder' => ['filled'],
            'folder.id' => ['required_with:folder', 'exists:folders,id'],
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => ['exists:categories,id'],
            'tags' => ['array'],
            'tags.*.id' => ['required', 'exists:tags,id']
        ];
    }
}
