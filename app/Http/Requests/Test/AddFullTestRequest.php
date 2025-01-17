<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class AddFullTestRequest extends BaseRequest{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'user_id' => 'required|numeric|exists:users,id',
            'expert_id' => 'required|numeric|exists:users,id',
            'questions' => 'required|array|min:1',
            'questions.*.type_question' => 'required|numeric|exists:question_types,id',
            'questions.*.question' => 'required|string|max:1000',
            'questions.*.options' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The test title is required.',
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user ID does not exist.',
            'expert_id.required' => 'The expert ID is required.',
            'expert_id.exists' => 'The selected expert ID does not exist.',
            'questions.required' => 'At least one question is required.',
            'questions.*.type_question.required' => 'The question type is required.',
            'questions.*.type_question.exists' => 'The selected question type is invalid.',
            'questions.*.question.required' => 'The question title is required.',
        ];
    }
}
