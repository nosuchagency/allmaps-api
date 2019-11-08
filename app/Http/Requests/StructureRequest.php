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
        if ($this->method() === 'POST') {
            return $this->rulesForCreating();
        }

        return $this->rulesForUpdating();
    }

    /**
     * @return array
     */
    public function rulesForCreating()
    {
        return [
            'name' => ['max:255'],
            'coordinates' => ['array'],
            'markers' => ['array'],
            'radius' => ['nullable', 'numeric', 'min:0'],
            'component' => ['required'],
            'component.id' => ['required', 'exists:components,id,deleted_at,NULL'],
            'floor' => ['required'],
            'floor.id' => ['required', 'exists:floors,id,deleted_at,NULL'],
        ];
    }

    /**
     * @return array
     */
    public function rulesForUpdating()
    {
        return [
            'name' => ['max:255'],
            'coordinates' => ['array'],
            'markers' => ['array'],
            'radius' => ['nullable', 'numeric', 'min:0'],
            'component' => ['filled'],
            'component.id' => ['required_with:component', 'exists:components,id,deleted_at,NULL'],
            'floor' => ['filled'],
            'floor.id' => ['required_with:floor', 'exists:floors,id,deleted_at,NULL'],
        ];
    }
}
