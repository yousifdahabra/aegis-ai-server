<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class AddUserAnswersRequest extends FormRequest{

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
}
