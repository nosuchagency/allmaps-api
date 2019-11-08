<?php

namespace App\Http\Requests;

use App\MenuItemType;
use App\Models\MenuItem;
use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class MenuItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', MenuItem::class);
        }

        return $this->user()->can('update', MenuItem::class);
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
            'order' => 'nullable|integer|min:0|max:4294967295',
            'shown' => 'boolean',
            'type' => [
                'required',
                Rule::in(array_keys(MenuItemType::TYPES)),
            ],
        ];

        if (Arr::has(MenuItemType::TYPES, $this->get('type'))) {
            $rules['model'] = 'required';
            $rules['model.id'] = ['required', 'exists:' . Arr::get(MenuItemType::TYPES, $this->get('type')) . ',id'];
        }

        if ($this->method() === 'POST') {
            $rules['menu'] = 'required';
            $rules['menu.id'] = 'required|exists:menus,id,deleted_at,NULL';
        } else {
            $rules['menu'] = ['nullable', new RequiredIdRule];
            $rules['menu.id'] = 'exists:menus,id,deleted_at,NULL';
        }

        return $rules;
    }
}
