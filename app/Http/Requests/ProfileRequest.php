<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'lastname'              =>  'required',
            'email'                 =>  'required|email|unique:users,email,'.Auth::id(),
            'phone'                 =>  'required|numeric|regex:#^03[2-4][0-9]{7}$#',
            'birth'                 =>  'required|date',
            'gender'                =>  'required|in:Male,Female',
            'marital_status'        =>  'required|in:Single,Married,Other',
            'identity'              =>  'required|image|max:2048',
            'city'                  =>  'required',
            'state'                 =>  'required',
            'postal_code'           =>  'numeric|digits:3',
            'address'               =>  'required',
            'occupation'            =>  'required',
            'occupation_place'      =>  'required',
            'occupation_duration'   =>  'required',
            'monthly_income'        =>  'required|numeric|min:1000',
        ];
    }
}
