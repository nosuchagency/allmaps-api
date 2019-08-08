<?php

namespace App\Http\Requests;

use App\Rules\RequiredIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BeaconRequest extends FormRequest
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
            'identifier' => [
                'required',
                Rule::unique('beacons')->ignore($this->route('beacon')),
            ],
            'description' => '',
            'proximity_uuid' => 'nullable|uuid',
            'major' => 'nullable|integer|between:0,65535',
            'minor' => 'nullable|integer|between:0,65535',
            'namespace' => '',
            'instance_id' => '',
            'url' => 'nullable|url',
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
