<?php

namespace App\Http\Requests;

use App\HitTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HitRequest extends FormRequest
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
            'type' => [
                'required',
                Rule::in(array_keys(HitTypes::TYPES)),
            ],
            'model' => 'required',
            'model.id' => ['required', 'exists:' . HitTypes::TYPES[$this->get('type')] . ',id'],
        ];
    }
}
