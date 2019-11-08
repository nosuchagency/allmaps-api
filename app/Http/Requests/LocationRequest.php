<?php

namespace App\Http\Requests;

use App\Models\Location;
use App\Rules\RequiredIdRule;
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
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Location::class);
        }

        return $this->user()->can('update', Location::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['max:255'],
            'zoom_from' => ['nullable', 'integer', 'min:0', 'max:4294967295'],
            'zoom_to' => ['nullable', 'integer', 'min:0', 'max:4294967295'],
            'title' => ['max:255'],
            'subtitle' => ['max:255'],
            'image' => [],
            'description' => ['max:65535'],
            'contact_name' => ['max:255'],
            'company' => ['max:255'],
            'address' => ['max:255'],
            'city' => ['max:255'],
            'postcode' => ['max:255'],
            'phone' => ['max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'search_activated' => ['boolean'],
            'search_text' => ['max:255'],
            'monday_from' => ['nullable', 'date_format:H:i'],
            'monday_to' => ['nullable', 'date_format:H:i'],
            'tuesday_from' => ['nullable', 'date_format:H:i'],
            'tuesday_to' => ['nullable', 'date_format:H:i'],
            'wednesday_from' => ['nullable', 'date_format:H:i'],
            'wednesday_to' => ['nullable', 'date_format:H:i'],
            'thursday_from' => ['nullable', 'date_format:H:i'],
            'thursday_to' => ['nullable', 'date_format:H:i'],
            'friday_from' => ['nullable', 'date_format:H:i'],
            'friday_to' => ['nullable', 'date_format:H:i'],
            'saturday_from' => ['nullable', 'date_format:H:i'],
            'saturday_to' => ['nullable', 'date_format:H:i'],
            'sunday_from' => ['nullable', 'date_format:H:i'],
            'sunday_to' => ['nullable', 'date_format:H:i'],
            'container' => ['nullable', new RequiredIdRule],
            'container.id' => ['exists:containers,id'],
            'activated_at' => ['nullable', 'date'],
            'publish_at' => ['nullable', 'date'],
            'unpublish_at' => ['nullable', 'date'],
            'coordinates' => ['nullable', 'array'],
            'searchables' => ['array'],
            'searchables.*.id' => ['required'],
            'searchables.*.fields' => ['required', 'array'],
            'searchables.*.fields.*.identifier' => ['required'],
            'searchables.*.fields.*.type' => ['required', 'in:text,boolean'],
            'searchables.*.fields.*.value' => ['present'],
            'category' => ['nullable', new RequiredIdRule],
            'category.id' => ['exists:categories,id'],
            'tags' => ['array'],
            'tags.*.id' => ['required', 'exists:tags,id']
        ];

        if ($this->method() === 'POST') {
            $rules['poi'] = ['nullable', 'required_if:type,poi', new RequiredIdRule];
            $rules['poi.id'] = ['exists:pois,id'];
            $rules['beacon'] = ['nullable', 'required_if:type,beacon', new RequiredIdRule];
            $rules['beacon.id'] = ['exists:beacons,id'];
            $rules['fixture'] = ['nullable', 'required_if:type,fixture', new RequiredIdRule];
            $rules['fixture.id'] = ['exists:fixtures,id'];
            $rules['floor'] = ['required'];
            $rules['floor.id'] = ['required', 'exists:floors,id,deleted_at,NULL'];
        }

        return $rules;
    }
}
