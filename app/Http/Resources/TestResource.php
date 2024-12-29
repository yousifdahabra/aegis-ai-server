<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'expert' => [
                'id' => $this->expert->id,
                'name' => $this->expert->name,
                'email' => $this->expert->email,
            ],
            'test_state' => [
                'id' => $this->test_state->id,
                'title' => $this->test_state->title,
            ],
        ];
    }
}
