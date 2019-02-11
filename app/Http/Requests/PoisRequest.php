<?php

namespace App\Http\Requests;

use App\Rules\Imageable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PoisRequest extends FormRequest
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
        return [
            'name' => 'required',
            'internal_name' => '',
            'type' => [
                'required',
                Rule::in(['icon', 'area']),
            ],
            'color' => '',
            'icon' => '',
            'category' => '',
            'tags' => 'present|array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
