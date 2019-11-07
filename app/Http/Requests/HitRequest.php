<?php

namespace App\Http\Requests;

use App\HitType;
use App\Models\Hit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
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
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Hit::class);
        }

        return $this->user()->can('update', Hit::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'type' => [
                'required',
                Rule::in(array_keys(HitType::TYPES)),
            ],
        ];

        if (Arr::has(HitType::TYPES, $this->get('type'))) {
            $rules['model'] = 'required';
            $rules['model.id'] = ['required', 'exists:' . Arr::get(HitType::TYPES, $this->get('type')) . ',id'];
        }

        return $rules;
    }
}
