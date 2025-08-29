<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function attemptLogin(array $credentials): array|null
    {

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        $token = $user->createToken('Token Akses')->accessToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
