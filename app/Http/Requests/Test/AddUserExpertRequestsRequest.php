<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class AddUserExpertRequestsRequest extends BaseRequest{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'about_user' => 'required|string',
            'user_note' => 'required|string',
            'links' => 'string',
            'user_id' => 'required|numeric|exists:users,id',
        ];
    }
    public function messages(): array
    {
        return [
            'about_user.required' => 'The about user field is required.',
            'about_user.string' => 'The about user must be a string.',
            'user_note.required' => 'The user note field is required.',
            'user_note.string' => 'The user note must be a string.',
            'links.string' => 'The links must be a string.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.numeric' => 'The user ID must be a valid number.',
            'user_id.exists' => 'The selected user ID does not exist in the database.',
        ];
    }

}
