<?php

namespace App\Http\Requests;

use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;

class ContainerRequest extends FormRequest
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
            'folders_enabled' => 'boolean',
            'mobile_skin' => ['nullable', new RequiredIdRule],
            'mobile_skin.id' => 'exists:skins,id',
            'tablet_skin' => ['nullable', new RequiredIdRule],
            'tablet_skin.id' => 'exists:skins,id',
            'desktop_skin' => ['nullable', new RequiredIdRule],
            'desktop_skin.id' => 'exists:skins,id',
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
