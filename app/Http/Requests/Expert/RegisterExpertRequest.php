<?php

namespace App\Http\Requests\Expert;

use App\Http\Requests\BaseRequest;

class RegisterExpertRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'extra_informations' => 'required|string|max:255',
            'links' => 'required|string',
            'documents' => 'required|array',
            'documents.*' => 'file|mimes:pdf|max:2048',
        ];
    }
    
    public function messages(){
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name field has a maximum 255 character limit.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.max' => 'The phone_number field has a maximum 255 character limit.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'extra_informations.required' => 'The extra informations field is required.',
            'extra_informations.max' => 'The extra informations field has a maximum 255 character limit.',
            'links.required' => 'The links field is required.',
            'documents.required' => 'The documents field is required.',
            'documents.min' => 'The documents must be at least 1 file.',
            'documents.*.max' => 'The documents field has a maximum 2048 bytes limit.',
        ];
    }

}
