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
}
