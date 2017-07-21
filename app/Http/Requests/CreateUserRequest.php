<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class CreateUserRequest extends FormRequest
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
        $rules = [
            'username' => 'required|min:3|max:50|unique:users',
            'password' => 'required|min:6|max:10|confirmed',
            'password_confirmation' => 'required|min:6|max:10',
            'email' => 'required|email|unique:users',
            'avatar' => 'required|mimes:jpeg,jpg,png|max:8192'
        ];
        return $rules;
    }
}
