<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class AddUserAnswersRequest extends BaseRequest{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|numeric|exists:users,id',
            'question_id' => 'required|numeric|exists:questions,id',
            'option_answer' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.numeric' => 'The user ID must be a valid number.',
            'user_id.exists' => 'The specified user does not exist in our records.',
            'question_id.required' => 'The question ID is required.',
            'question_id.numeric' => 'The question ID must be a valid number.',
            'question_id.exists' => 'The specified question does not exist in our records.',
            'option_answer.required' => 'The option answer field is required.',
            'option_answer.string' => 'The option answer must be a valid string.',
        ];
    }

}
