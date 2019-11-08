<?php

namespace App\Http\Requests;

use App\Models\Beacon;
use App\Models\Container;
use App\Pivots\BeaconContainer;
use Illuminate\Foundation\Http\FormRequest;

class ContainerBeaconRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'beacon' => ['required'],
            'beacon.id' => ['required', 'exists:beacons,id,deleted_at,NULL']
        ];
    }
}
