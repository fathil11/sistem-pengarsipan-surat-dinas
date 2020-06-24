<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailOutRequest extends FormRequest
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
            'title' => 'required|min:3|max:255',
            'mail_folder_id' => 'required|numeric|min:1|max:255|exists:mail_folders,id',
            'mail_type_id' => 'required|numeric|min:1|max:255|exists:mail_types,id',
            'mail_reference_id' => 'required|numeric|min:1|max:255|exists:mail_references,id',
            'mail_priority_id' => 'required|numeric|min:1|max:255|exists:mail_priorities,id',
            'mail_created_at' => 'required|date',
            'file' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:5120',
        ];
    }
}
