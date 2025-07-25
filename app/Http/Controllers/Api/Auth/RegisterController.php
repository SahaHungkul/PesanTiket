<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\RegisterResource;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;



class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $role = Role::where('name', 'user')->first();
        // Create a new user instance
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $role->id,
        ]);

        $user->assignRole('user');

        $role = Role::where('name', 'user')->first();
        $user->role_id = $role->id;
        $user->save();

        $token = $user->createToken('TokenLogin')->accessToken;

        // Optionally, you can return a response or token
        return new RegisterResource([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
