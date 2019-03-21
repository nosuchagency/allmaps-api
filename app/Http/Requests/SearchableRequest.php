<?php

namespace App\Http\Requests;

use App\Rules\PluginExists;
use Illuminate\Foundation\Http\FormRequest;

class SearchableRequest extends FormRequest
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
            'identifier' => [
                'unique:searchables',
                new PluginExists
            ],
            'activated' => 'boolean'
        ];

        if ($this->method() === 'POST') {
            $rules['identifier'][] = 'required';
            $rules['name'] = 'required';
        }

        return $rules;
    }
}
