<?php

namespace App\Http\Requests;

use App\Distance;
use App\Models\Rule;
use App\Weekday;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class RuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Rule::class);
        }

        return $this->user()->can('update', Rule::class);
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
            'distance' => [
                'required',
                ValidationRule::in(Distance::DISTANCES),
            ],
            'weekday' => [
                'required',
                ValidationRule::in(Weekday::WEEKDAYS),
            ],
            'discovery_time' => ['nullable', 'integer', 'max:4294967295'],
            'time_restricted' => ['boolean'],
            'date_restricted' => ['boolean'],
            'time_from' => ['nullable', 'date_format:H:i'],
            'time_to' => ['nullable', 'date_format:H:i'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'push_title' => ['nullable', 'max:255'],
            'push_body' => ['nullable', 'max:255'],
        ];
    }

    /**
     * @return array
     */
    public function rulesForUpdating()
    {
        return [
            'distance' => [
                'filled',
                ValidationRule::in(Distance::DISTANCES),
            ],
            'weekday' => [
                'filled',
                ValidationRule::in(Weekday::WEEKDAYS),
            ],
            'discovery_time' => ['nullable', 'integer', 'max:4294967295'],
            'time_restricted' => ['boolean'],
            'date_restricted' => ['boolean'],
            'time_from' => ['nullable', 'date_format:H:i'],
            'time_to' => ['nullable', 'date_format:H:i'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'push_title' => ['nullable', 'max:255'],
            'push_body' => ['nullable', 'max:255'],
        ];
    }
}
