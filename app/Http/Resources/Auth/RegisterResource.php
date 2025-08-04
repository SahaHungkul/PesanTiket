<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return
            [
                'message' => 'User registered successfully',
                'data' =>
                [
                    'user' =>
                    [
                        'id' => $this['user']->id,
                        'name' => $this['user']->name,
                        'email' => $this['user']->email,
                        // 'roles' => $this['user']->getRoleNames()->first(), // Assuming roles are managed by Spatie
                    ],
                    'token' => $this['token'],
                ],
            ];
    }
}
