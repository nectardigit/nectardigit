<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerApplicationRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'mobile' => ['numeric', 'digits:10', 'starts_with:98,97'],
            'email' => ['required', 'email:rfc,dns'],
            'description' => ['required'],
            'documents.*' => ['required','mimes:docx,doc,pdf,jpeg,jpg','max:2048'],
        ];
    }
}
