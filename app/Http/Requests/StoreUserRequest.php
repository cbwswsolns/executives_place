<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        $ukPhoneRegex = "^(?:(?:\(?(?:0(?:0|11)\)?[\s-]?\(?|\+)44\)?[\s-]?(?:\(?0\)?[\s-]?)?)|(?:\(?0))(?:(?:\d{5}\)?[\s-]?\d{4,5})|(?:\d{4}\)?[\s-]?(?:\d{5}|\d{3}[\s-]?\d{3}))|(?:\d{3}\)?[\s-]?\d{3}[\s-]?\d{3,4})|(?:\d{2}\)?[\s-]?\d{4}[\s-]?\d{4}))(?:[\s-]?(?:x|ext\.?|\#)\d{3,4})?$";

        return [
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'job_title' => 'required|string|max:255',
            'phone' => ['required', 'regex:/' . $ukPhoneRegex . '/', 'min:10'],
            'email' => 'required|string|email|max:255|unique:users',
            'hourly_rate' => 'required|numeric|between:0,999999',
            'currency' => 'required|in:' .
                implode(',', config('exchangerate.allowed_currencies'))
        ];
    }
}
