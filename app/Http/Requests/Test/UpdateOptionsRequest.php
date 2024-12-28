<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class UpdateOptionsRequest extends BaseRequest{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
        ];
    }
}
