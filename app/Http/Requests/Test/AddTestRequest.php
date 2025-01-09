<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class AddTestRequest extends BaseRequest{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'user_id' => 'required|numeric|exists:users,id',
            'expert_id' => 'numeric',
            'test_state_id' => 'required|numeric|exists:test_states,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'user_id.required' => 'The user ID is required.',
            'user_id.numeric' => 'The user ID must be a number.',
            'user_id.exists' => 'The selected user ID does not exist in the users table.',
            'expert_id.numeric' => 'The expert ID must be a number.',
            'test_state_id.required' => 'The test state ID is required.',
            'test_state_id.numeric' => 'The test state ID must be a number.',
            'test_state_id.exists' => 'The selected test state ID does not exist in the test_states table.',
        ];
    }

}
