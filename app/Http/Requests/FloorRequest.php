<?php

namespace App\Http\Requests;

use App\Models\Floor;
use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;

class FloorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Floor::class);
        }

        return $this->user()->can('update', Floor::class);
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
            'level' => 'nullable|integer'
        ];

        if ($this->method() === 'POST') {
            $rules['building'] = 'required';
            $rules['building.id'] = 'required|exists:buildings,id,deleted_at,NULL';
        } else {
            $rules['building'] = ['nullable', new RequiredIdRule];
            $rules['building.id'] = 'exists:buildings,id,deleted_at,NULL';
        }

        return $rules;
    }
}
