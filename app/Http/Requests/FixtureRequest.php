<?php

namespace App\Http\Requests;

use App\Models\Fixture;
use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;

class FixtureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Fixture::class);
        }

        return $this->user()->can('update', Fixture::class);
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
            'description' => [],
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
