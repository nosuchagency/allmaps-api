<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
        $rules = [
            'name' => '',
            'zoom_from' => 'nullable|integer|min:0',
            'zoom_to' => 'nullable|integer|min:0',
            'title' => '',
            'subtitle' => '',
            'image' => '',
            'description' => '',
            'contact_name' => '',
            'company' => '',
            'address' => '',
            'city' => '',
            'postcode' => '',
            'phone' => '',
            'email' => 'nullable|email',
            'search_activated' => 'boolean',
            'search_text' => '',
            'monday_from' => 'nullable|date_format:H:i',
            'monday_to' => 'nullable|date_format:H:i',
            'tuesday_from' => 'nullable|date_format:H:i',
            'tuesday_to' => 'nullable|date_format:H:i',
            'wednesday_from' => 'nullable|date_format:H:i',
            'wednesday_to' => 'nullable|date_format:H:i',
            'thursday_from' => 'nullable|date_format:H:i',
            'thursday_to' => 'nullable|date_format:H:i',
            'friday_from' => 'nullable|date_format:H:i',
            'friday_to' => 'nullable|date_format:H:i',
            'saturday_from' => 'nullable|date_format:H:i',
            'saturday_to' => 'nullable|date_format:H:i',
            'sunday_from' => 'nullable|date_format:H:i',
            'sunday_to' => 'nullable|date_format:H:i',
            'activated_at' => 'nullable|date',
            'publish_at' => 'nullable|date',
            'unpublish_at' => 'nullable|date',
            'coordinates' => 'nullable|array',
            'searchables' => 'array',
            'searchables.*.id' => 'required',
            'searchables.*.fields' => 'required|array',
            'searchables.*.fields.*.identifier' => 'required',
            'searchables.*.fields.*.type' => 'required|in:text,boolean',
            'searchables.*.fields.*.value' => 'present',
        ];

        if ($this->method() === 'POST') {
            $rules['poi.id'] = 'nullable|exists:pois,id,deleted_at,NULL|required_without_all:beacon.id,fixture.id';
            $rules['beacon.id'] = 'nullable|exists:beacons,id,deleted_at,NULL|required_without_all:poi.id,fixture.id';
            $rules['fixture.id'] = 'nullable|exists:fixtures,id,deleted_at,NULL|required_without_all:poi.id,beacon.id';
            $rules['floor'] = 'required';
            $rules['floor.id'] = 'required|exists:floors,id,deleted_at,NULL';
        }

        return $rules;
    }
}
