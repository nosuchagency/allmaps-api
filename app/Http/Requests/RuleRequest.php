<?php

namespace App\Http\Requests;

use App\Distance;
use App\Weekday;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RuleRequest extends FormRequest
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
            'distance' => [
                'required',
                Rule::in(Distance::DISTANCES),
            ],
            'weekday' => [
                'required',
                Rule::in(Weekday::WEEKDAYS),
            ],
            'time_restricted' => 'boolean',
            'date_restricted' => 'boolean',
            'time_from' => 'nullable|date_format:H:i',
            'time_to' => 'nullable|date_format:H:i',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date'
        ];
    }
}
