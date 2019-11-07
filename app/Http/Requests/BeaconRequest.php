<?php

namespace App\Http\Requests;

use App\Models\Beacon;
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
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Beacon::class);
        }

        return $this->user()->can('update', Beacon::class);
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
            'identifier' => ['required', 'unique:beacons'],
            'description' => ['max:65535'],
            'proximity_uuid' => ['nullable', 'uuid'],
            'major' => ['nullable', 'integer', 'between:0,65535'],
            'minor' => ['nullable', 'integer', 'between:0,65535'],
            'namespace' => [],
            'instance_id' => [],
            'url' => ['nullable', 'url'],
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => ['exists:categories,id'],
            'tags' => ['array'],
            'tags.*.id' => ['required', 'exists:tags,id']
        ];
    }

    /**
     * @return array
     */
    public function rulesForUpdating()
    {
        return [
            'name' => ['filled', 'max:255'],
            'identifier' => ['filled', Rule::unique('beacons')->ignore($this->route('beacon'))],
            'description' => ['max:65535'],
            'proximity_uuid' => ['nullable', 'uuid'],
            'major' => ['nullable', 'integer', 'between:0,65535'],
            'minor' => ['nullable', 'integer', 'between:0,65535'],
            'namespace' => [],
            'instance_id' => [],
            'url' => ['nullable', 'url'],
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => ['exists:categories,id'],
            'tags' => ['array'],
            'tags.*.id' => ['required', 'exists:tags,id']
        ];
    }
}
