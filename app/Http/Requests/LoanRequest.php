<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
            'amount'        =>  'required|numeric|min:1000',
            'password'      =>  'required',
            'description'   =>  'required',
            'attachment'    =>  'required|file|mimes:png,jpg,pdf,jpeg,docx,doc|max:2048'
        ];
    }
}
