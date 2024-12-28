<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class UpdateUserAnswersRequest extends BaseRequest{

    public function rules(): array
    {
        return [
            'option_answer' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'option_answer.required' => 'The option answer field is required.',
            'option_answer.string' => 'The option answer must be a valid string.',
        ];
    }

}
