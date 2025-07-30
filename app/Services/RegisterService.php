<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterService
{
    public function register(array $data): array
    {
        $role = Role::where('name', 'user')->first();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $role->id,
        ]);

        $user->assignRole('user');

        $token = $user->createToken('TokenLogin')->accessToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
