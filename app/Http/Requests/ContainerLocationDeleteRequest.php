<?php

namespace App\Http\Requests;

use App\Models\Container;
use Illuminate\Foundation\Http\FormRequest;

class ContainerLocationDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('delete', Container::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data' => ['required', 'array'],
            'data.*.id' => ['required', 'exists:locations,id,deleted_at,NULL'],
        ];
    }
}
