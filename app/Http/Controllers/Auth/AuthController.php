<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Auth",
    description: "Endpoints para autenticación y gestión de tokens."
)]
class AuthController extends Controller
{
    /**
     * User Login
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: "/api/auth/login",
        summary: "Iniciar sesión de usuario",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email", example: "user@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "********")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Login exitoso"),
            new OA\Response(response: 401, description: "No autorizado"),
            new OA\Response(response: 422, description: "Error de validación"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
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
    #[OA\Post(
        path: "/api/auth/refresh-token",
        summary: "Validar y refrescar token de usuario",
        tags: ["Auth"],
        responses: [
            new OA\Response(response: 200, description: "Token refrescado exitosamente"),
            new OA\Response(response: 401, description: "No autorizado"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
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
