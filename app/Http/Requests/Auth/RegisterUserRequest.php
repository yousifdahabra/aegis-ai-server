<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterUserRequest extends BaseRequest{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone_number' => 'string|max:255',
            'birth_year' => 'numeric|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name field has a maximum 255 character limit.',
            'phone_number.max' => 'The phone_number field has a maximum 255 character limit.',
            'birth_year.max' => 'The birth_year field has a maximum 255 character limit.',
            'birth_year.numeric' => 'The birth_year must be a number.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }


}
