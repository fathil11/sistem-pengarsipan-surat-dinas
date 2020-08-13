<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class MailInRequest extends FormRequest
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
            'directory_code' => 'required|min:3|max:50',
            'code' => 'required|min:2|unique:mails|max:50',
            'title' => 'required|min:3|max:255',
            'origin' => 'required|min:3|max:50',
            'mail_folder_id' => 'required|numeric|min:1|max:255|exists:mail_folders,id',
            'mail_type_id' => 'required|numeric|min:1|max:255|exists:mail_types,id',
            'mail_reference_id' => 'required|numeric|min:1|max:255|exists:mail_references,id',
            'mail_priority_id' => 'required|numeric|min:1|max:255|exists:mail_priorities,id',

            'file' => 'file|mimes:pdf,doc,docx,jpeg,jpg,png|max:5120',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'mail_created_at' => Carbon::parseFromLocale($this->mail_created_at),
        ]);
    }
}
