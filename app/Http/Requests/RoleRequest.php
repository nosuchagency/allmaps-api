<?php

namespace App\Http\Requests;

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
            'permissions' => 'array',
            'permissions.*.id' => 'required|exists:permissions,id'
        ];

        if ($this->method() === 'POST') {
            $rules['name'] = 'required';
        } else {
            $rules['name'] = 'sometimes|required';
        }

        return $rules;
    }
}
