<?php

namespace App\Http\Requests;

use App\Models\Place;
use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;

class PlaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Place::class);
        }

        return $this->user()->can('update', Place::class);
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
            'address' => ['max:255'],
            'postcode' => ['max:255'],
            'city' => ['max:255'],
            'image' => [],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'activated' => ['boolean'],
            'menu' => ['nullable', new RequiredIdRule],
            'menu.id' => 'exists:menus,id',
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
            'address' => ['max:255'],
            'postcode' => ['max:255'],
            'city' => ['max:255'],
            'image' => [],
            'latitude' => ['filled', 'numeric'],
            'longitude' => ['filled', 'numeric'],
            'activated' => ['boolean'],
            'menu' => ['nullable', new RequiredIdRule],
            'menu.id' => 'exists:menus,id',
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => ['exists:categories,id'],
            'tags' => ['array'],
            'tags.*.id' => ['required', 'exists:tags,id']
        ];
    }
}
