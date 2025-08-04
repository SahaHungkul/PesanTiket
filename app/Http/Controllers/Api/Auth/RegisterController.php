<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\RegisterResource;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\RegisterService;

class RegisterController extends Controller
{
    protected RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $result = $this->registerService->register($validated);

        // Optionally, you can return a response or token
        return response()->json([
            'message' => 'User registered successfully',
            'data' => new RegisterResource($result),
        ]);
    }
}
