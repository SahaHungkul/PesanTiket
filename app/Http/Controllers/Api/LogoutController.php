<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        
        $request->user()->tokens()->revoke();

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil',
        ], 200);
    }
}
