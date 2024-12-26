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

        ];
    }
}
