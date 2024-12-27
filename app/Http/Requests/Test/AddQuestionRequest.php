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
            'previous_question_id' => 'numeric|exists:questions,id',
            'options' => 'required|array|min:2',
            'options.*.title' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'test_id.required' => 'The test ID is required.',
            'test_id.numeric' => 'The test ID must be a number.',
            'test_id.exists' => 'The selected test ID does not exist in the tests table.',
            'question_type_id.required' => 'The question type ID is required.',
            'question_type_id.numeric' => 'The question type ID must be a number.',
            'question_type_id.exists' => 'The selected question type ID does not exist in the question_types table.',
            'previous_question_id.numeric' => 'The previous question ID must be a number.',
            'previous_question_id.exists' => 'The selected previous question ID does not exist in the questions table.',
        ];
    }






}
