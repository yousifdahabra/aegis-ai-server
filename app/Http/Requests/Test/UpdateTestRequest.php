<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class UpdateTestRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
        ];
    }
}
