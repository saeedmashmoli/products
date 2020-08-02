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
        if($this->method() == 'POST') {
            return [
                'username' => 'required|unique:users',
                'role_id' => 'required',
                'mobile' => 'required|numeric|unique:users',
                'email' => 'nullable|email',
                'password' => 'required'
            ];
        }else{
            return [
                'role_id' => 'required',
                'mobile' => 'nullable|numeric',
                'email' => 'nullable|email'
                ];
        }
    }
}
