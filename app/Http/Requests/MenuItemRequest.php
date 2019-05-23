<?php

namespace App\Http\Requests;

use App\MenuItemType;
use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;
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
            'type' => [
                'required',
                Rule::in(MenuItemType::TYPES),
            ],
            'poi' => ['nullable', 'required_if:type,poi', new RequiredIdRule],
            'poi.id' => 'exists:pois,id',
            'location' => ['nullable', 'required_if:type,location', new RequiredIdRule],
            'location.id' => 'exists:locations,id',
            'tag' => ['nullable', 'required_if:type,tag', new RequiredIdRule],
            'tag.id' => 'exists:tags,id',
            'category' => ['nullable', 'required_if:type,category', new RequiredIdRule],
            'category.id' => 'exists:categories,id',
        ];

        if ($this->method() === 'POST') {
            $rules['menu'] = 'required';
            $rules['menu.id'] = 'required|exists:menus,id,deleted_at,NULL';
        }

        return $rules;
    }
}
