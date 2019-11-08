<?php

namespace App\Http\Requests;

use App\Models\Skin;
use App\Rules\SkinZipFileRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SkinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return $this->user()->can('create', Skin::class);
        }

        return $this->user()->can('update', Skin::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => [
                'required',
                'max:255',
                Rule::unique('skins')->ignore($this->route('skin')),
            ],
            'file' => ['file', 'mimes:zip', new SkinZipFileRule],
            'mobile' => ['boolean'],
            'tablet' => ['boolean'],
            'desktop' => ['boolean'],
        ];

        if ($this->method() === 'POST') {
            $rules['file'][] = 'required';
        } else {
            $rules['file'][] = 'nullable';
        }

        return $rules;
    }
}
