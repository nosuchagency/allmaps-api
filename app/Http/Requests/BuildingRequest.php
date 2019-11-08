<?php

namespace App\Http\Requests;

use App\Models\Building;
use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;

class BuildingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Building::class);
        }

        return $this->user()->can('update', Building::class);
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
            'image' => [],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'menu' => ['nullable', new RequiredIdRule],
            'menu.id' => ['exists:menus,id'],
            'place' => ['required'],
            'place.id' => ['required', 'exists:places,id,deleted_at,NULL'],
        ];
    }

    /**
     * @return array
     */
    public function rulesForUpdating()
    {
        return [
            'name' => ['filled', 'max:255'],
            'image' => [],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'menu' => ['nullable', new RequiredIdRule],
            'menu.id' => ['exists:menus,id'],
            'place' => ['filled'],
            'place.id' => ['required_with:place', 'exists:places,id,deleted_at,NULL'],
        ];
    }
}
