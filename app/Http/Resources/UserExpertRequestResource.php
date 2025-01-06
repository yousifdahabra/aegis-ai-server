<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserExpertRequestResource extends JsonResource{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'about_user' => $this->about_user,
            'user_note' => $this->user_note,
            'links' => $this->links,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
        ];
    }
}
