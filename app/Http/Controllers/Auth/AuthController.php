<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * User Login
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request) : JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validate->fails()) return response()->json([
            'message' => 'Validation Error',
            'errors' => $validate->errors()
        ], 422);

        try {

            $user = User::where('email', $request->email)->first();
            if (!$user || !password_verify($request->password, $user->password)) return response()->json([
                'message' => 'Unauthorized'
            ], 401);

            if ($user->hasRole('admin') == true) {

                $role = $user->roles->pluck('name');
                $token = $user->createToken('auth_token', $role->toArray())->plainTextToken;

                return response()->json([
                    'token' => $token,
                    'role' => $role,
                    'user' => $user
                ]);

            }  else {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate token
     * @return JsonResponse
     */
    public function refreshToken() : JsonResponse
    {
        try {

            $user = Auth::user();
            if (!$user) return response()->json([
                'message' => 'Unauthorized'
            ], 401);

            $user->tokens()->delete();
            $role = $user->roles->pluck('name');
            $token = $user->createToken('auth_token', $role->toArray())->plainTextToken;

            return response()->json([
                'token' => $token,
                'role' => $role,
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
