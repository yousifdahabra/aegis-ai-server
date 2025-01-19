<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestListResource extends JsonResource{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'expert_id' => $this->expert_id,
            'security' => $this->security_grade,
            'user_name' => $this->user->name,
            'test_state' => $this->test_state->title,
            'questions_count' => $this->questions->count(),
        ];
        }

}
