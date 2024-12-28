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


}
