<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'lastname'      =>  'required',
            'email'         =>  'required|email:rfc,dns,filter,strict',
            'password'      =>  'required|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'lastname.required' =>  "Lastname is required!",
            'email.required'    =>  "Email address is required!",
            'email.email'       =>  "Invalid email address!",
            'password.required' =>  "Password is required!",
            'password.confirmed'=>  "Password doesn't match!"
        ];
    }
}
