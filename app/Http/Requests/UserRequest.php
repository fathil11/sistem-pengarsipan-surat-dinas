<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'nip' => 'required|min:3|max:100',
            'name' => 'required|min:3|max:255',
            'user_position_id' => 'required|numeric|min:1|max:255',
            'user_department_id' => 'nullable|numeric|min:1|max:255',
            'user_position_detail_id' => 'nullable|numeric|min:1|max:255',
            'email' => 'required|min:3|max:255|email:rfc',
            'phone_number' => 'required|min:4|max:25',
            'username' => 'required|min:3|max:255',
            'password' => 'required|min:6|max:512',
        ];
    }
}
