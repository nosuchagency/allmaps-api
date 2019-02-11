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
            'title' => 'required',
            'yt_url' => 'required|url',
            'category' => '',
            'tags' => 'present|array',
            'tags.*.id' => 'required|exists:tags,id'
        ];
    }
}
