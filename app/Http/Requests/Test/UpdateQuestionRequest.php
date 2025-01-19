<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'question_type_id' => 'required|numeric|exists:question_types,id',
            'options' => 'required|array|min:1',
            'options.*.id' => 'required|numeric',
            'options.*.title' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title must not exceed 255 characters.',
            'question_type_id.required' => 'The question type is required.',
            'question_type_id.numeric' => 'The question type must be a valid number.',
            'question_type_id.exists' => 'The selected question type is invalid.',
            'options.required' => 'At least one option is required.',
            'options.array' => 'The options must be an array.',
            'options.min' => 'There must be at least one option.',
            'options.*.id.required' => 'Each option must have a valid ID.',
            'options.*.id.numeric' => 'Each option ID must be a valid number.',
            'options.*.title.required' => 'Each option must have a title.',
            'options.*.title.string' => 'Each option title must be a string.',
            'options.*.title.max' => 'Each option title must not exceed 255 characters.',
        ];
    }

}
