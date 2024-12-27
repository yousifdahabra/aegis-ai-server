<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class AddQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'test_id' => 'required|numeric|exists:tests,id',
            'question_type_id' => 'required|numeric|exists:question_types,id',
            'previous_question_id' => 'numeric|exists:test_states,id',
        ];
    }
}
