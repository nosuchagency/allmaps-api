<?php

namespace App\Http\Requests;

use App\Models\Structure;
use Illuminate\Foundation\Http\FormRequest;

class StructureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Structure::class);
        }

        return $this->user()->can('update', Structure::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'max:255',
            'coordinates' => 'array',
            'markers' => 'array',
            'radius' => 'nullable|numeric|min:0',
        ];

        if ($this->method() === 'POST') {
            $rules['component'] = 'required';
            $rules['component.id'] = 'required|exists:components,id,deleted_at,NULL';
            $rules['floor'] = 'required';
            $rules['floor.id'] = 'required|exists:floors,id,deleted_at,NULL';
        }

        return $rules;
    }
}
