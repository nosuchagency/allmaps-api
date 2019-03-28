<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoContentRequest extends FormRequest
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
            'yt_url' => 'required|url',
            'category' => '',
            'tags' => 'array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
