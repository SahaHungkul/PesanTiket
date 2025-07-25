<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'token' => $this['token'],
                'type' => 'Bearer',
                'user' => [
                    'id' => $this->id,
                    'name' => $this->name,
                    'email' => $this->email,
                    // Add other user attributes as needed
                ],
            ];
    }
}
