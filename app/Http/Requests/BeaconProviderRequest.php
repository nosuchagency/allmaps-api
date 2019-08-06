<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeaconProviderRequest extends FormRequest
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
            'name' => 'required|max:255',
            'type' => 'required|in:kontakt,estimote',
            'meta.api_key' => 'required_if:type,kontakt',
            'meta.app_id' => 'required_if:type,estimote',
            'meta.app_token' => 'required_if:type,estimote'
        ];
    }
}
