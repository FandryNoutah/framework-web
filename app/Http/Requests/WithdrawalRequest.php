<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalRequest extends FormRequest
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
            'amount'    =>  'required|numeric|min:1000',
            'password'  =>  'required'
        ];
    }

    public function messages()
    {
        return [
            'amount.required'   =>  "Withdrawal amount is required!",
            'amount.numeric'    =>  "Amount is invalid!",
            'amount.min'        =>  "Minimum withdrawal amount is :min Ariary!",
            'password.required' =>  "Password is required!"
        ];
    }
}
