<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class UpdateUserRequest extends BaseRequest{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone_number' => 'string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'string|min:6',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name field has a maximum 255 character limit.',
            'phone_number.max' => 'The phone_number field has a maximum 255 character limit.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'password.min' => 'Password must be at least 8 characters long.',
        ];
    }

}
