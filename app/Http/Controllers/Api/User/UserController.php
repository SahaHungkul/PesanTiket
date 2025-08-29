<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            return response()->json([
                'message' => 'Users retrieved successfully',
                'data' => UserResource::collection(User::paginate(10)),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving users: ' . $e->getMessage()], 500);
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            $roleName = $data['role'];

            $role = Role::where('name', $roleName)->firstOrFail();

            $user->assignRole($roleName);
            $user->role_id = $role->id;
            $user->save();


            // $tokenResult = $user->createToken('Akses Token');
            // $token = $tokenResult->accessToken; // token

            return response()->json([
                'user'  => new UserResource($user),
                // 'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
            'message' => 'Terjadi kesalahan saat membuat user.',
            'error'   => $e->getMessage(), // bisa dihapus di production
        ], 500);
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'message' => 'User tidak ditemukan.'
            ], 404);
        }

        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan.'
            ], 404);
        }
        $user->delete();
        return response()->json([
            'message' => 'User berhasil dihapus.'
        ], 200);
    }
}
