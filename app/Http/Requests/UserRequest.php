<?php

namespace App\Http\Requests;

use App\Locale;
use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserRequest extends FormRequest
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
            'password' => [],
            'locale' => ['nullable', Rule::in(Locale::LOCALES)],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('user'))
            ],
            'role' => 'required',
            'role.id' => 'required|exists:roles,id',
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*.id' => 'required|exists:tags,id'
        ];

        if ($this->method() === 'POST') {
            $rules['password'][] = 'required';
        }

        return $rules;
    }
}
