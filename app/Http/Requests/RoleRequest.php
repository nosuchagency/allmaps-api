<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Role::class);
        }

        return $this->user()->can('update', Role::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['sometimes', 'required', 'max:255'],
            'permissions' => 'array',
            'permissions.*.id' => 'required|exists:permissions,id'
        ];

        if ($this->method() === 'POST') {
            $rules['name'] = ['required', 'max:255'];
        }

        return $rules;
    }
}
