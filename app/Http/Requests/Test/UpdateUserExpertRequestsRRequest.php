<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class UpdateUserExpertRequestsRRequest extends BaseRequest{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'about_user' => 'required|string',
            'user_note' => 'required|string',
            'links' => 'required|string',
        ];
    }
}
