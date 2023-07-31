<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CareerRequest extends FormRequest
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
            'slug'=>['required'],
            'title' => ['required'],
            'deadLine' => ['required', 'date'],
            'experience' => ['required'],
            'qualification' => ['required'],
            'description' => ['required'],
            'publish_status' => ['required'],
            'image' => ['nullable', 'url']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->title) . '-' . Str::random(4),
        ]);
    }
}
