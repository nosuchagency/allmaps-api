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
            'name' => ['required', 'max:255'],
            'level' => ['nullable', 'integer', 'max:4294967295'],
            'building' => ['required'],
            'building.id' => ['required', 'exists:buildings,id,deleted_at,NULL'],
        ];
    }

    /**
     * @return array
     */
    public function rulesForUpdating()
    {
        return [
            'name' => ['filled', 'max:255'],
            'level' => ['nullable', 'integer', 'max:4294967295'],
            'building' => ['filled'],
            'building.id' => ['required_with:building', 'exists:buildings,id,deleted_at,NULL'],
        ];
    }
}
