<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class AddUserExpertRequestsRequest extends BaseRequest{

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
            'user_id' => 'required|numeric|exists:users,id',
            'expert_id' => 'required|numeric|exists:users,id',
        ];
    }
}
