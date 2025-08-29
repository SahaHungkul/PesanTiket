<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();

            // Cari role 'user' dengan guard 'api'
            $role = Role::where('name', 'user')
                ->where('guard_name', 'api')
                ->first();

            if (!$role) {
                return response()->json(['message' => 'Role user tidak tersedia'], 500);
            }

            // Buat user baru
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $role->id, // isi role_id
            ]);

            // Assign role untuk Spatie
            $user->assignRole('user');

            // Buat token langsung
            $token = $user->createToken('TokenLogin')->accessToken;

            return response()->json([
                'message' => 'User registered successfully',
                'data' => [
                    'user' => new RegisterResource(['user' => $user]),
                    'token' => $token,
                ]
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
