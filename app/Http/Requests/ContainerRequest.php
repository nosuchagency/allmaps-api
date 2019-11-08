<?php

namespace App\Http\Requests;

use App\Models\Container;
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
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Container::class);
        }

        return $this->user()->can('update', Container::class);
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
            'description' => ['max:65535'],
            'folders_enabled' => 'boolean',
            'mobile_skin' => ['nullable', new RequiredIdRule],
            'mobile_skin.id' => 'exists:skins,id',
            'tablet_skin' => ['nullable', new RequiredIdRule],
            'tablet_skin.id' => 'exists:skins,id',
            'desktop_skin' => ['nullable', new RequiredIdRule],
            'desktop_skin.id' => 'exists:skins,id',
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
            'description' => ['max:65535'],
            'folders_enabled' => 'boolean',
            'mobile_skin' => ['nullable', new RequiredIdRule],
            'mobile_skin.id' => 'exists:skins,id',
            'tablet_skin' => ['nullable', new RequiredIdRule],
            'tablet_skin.id' => 'exists:skins,id',
            'desktop_skin' => ['nullable', new RequiredIdRule],
            'desktop_skin.id' => 'exists:skins,id',
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => ['exists:categories,id'],
            'tags' => ['array'],
            'tags.*.id' => ['required', 'exists:tags,id']
        ];
    }
}
