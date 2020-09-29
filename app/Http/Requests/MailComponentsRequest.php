<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailComponentsRequest extends FormRequest
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
            'type' => 'required|min:3|max:50',
            'code' => 'required|min:2|max:50',
            'color' => 'required|min:3|max:50',
        ];
    }
}
