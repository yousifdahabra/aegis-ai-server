<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class UpdateUserExpertRequestsRRequest extends BaseRequest{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'about_user' => 'required|string',
            'user_note' => 'required|string',
            'links' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'about_user.required' => 'The about user field is required.',
            'about_user.string' => 'The about user must be a string.',
            'user_note.required' => 'The user note field is required.',
            'user_note.string' => 'The user note must be a string.',
            'links.required' => 'The links field is required.',
            'links.string' => 'The links must be a string.',
        ];
    }

}
