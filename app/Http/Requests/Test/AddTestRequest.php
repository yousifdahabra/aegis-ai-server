<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;

class AddTestRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'user_id' => 'required|numeric|exists:users,id',
            'expert_id' => 'required|numeric|exists:users,id',
            'test_state_id' => 'required|numeric|exists:test_states,id',
        ];
    }
}
