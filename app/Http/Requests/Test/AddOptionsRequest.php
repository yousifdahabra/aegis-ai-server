<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class AddOptionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'question_id' => 'required|numeric|exists:questions,id',
        ];
    }
}
