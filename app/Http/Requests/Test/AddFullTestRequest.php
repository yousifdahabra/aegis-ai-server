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
            'questions.*.options.*.title' => 'required_with:questions.*.options|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
        ];
    }
}
