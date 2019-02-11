<?php

namespace App\Http\Requests;

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
        $user = $this->route('user');

        $rules = [
            'name' => 'required',
            'password' => '',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user),
            ],
            'role' => [
                'required',
                Rule::in(Role::all()->pluck('name')),
            ],
            'category' => '',
            'tags' => 'present|array',
            'tags.*.id' => 'required|exists:tags,id'
        ];

        if (!$user) {
            $rules['password'] = 'required';
        }

        return $rules;
    }
}
