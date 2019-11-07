<?php

namespace App\Http\Requests;

use App\Pivots\BeaconContainer;
use Illuminate\Foundation\Http\FormRequest;

class BeaconContainerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', BeaconContainer::class);
        }

        return $this->user()->can('update', BeaconContainer::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'container' => ['required'],
            'container.id' => ['required', 'exists:containers,id,deleted_at,NULL']
        ];
    }
}
