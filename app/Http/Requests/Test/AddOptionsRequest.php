<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class AddOptionsRequest extends BaseRequest{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'question_id' => 'required|numeric|exists:questions,id',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'question_id.required' => 'The question ID is required.',
            'question_id.numeric' => 'The question ID must be a number.',
            'question_id.exists' => 'The selected question does not exist.',
        ];
    }
}
