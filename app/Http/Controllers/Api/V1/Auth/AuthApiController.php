<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    public function __construct(private readonly LoginService $loginService) {}

    public function login(Request $request): JsonResponse
    {
        $user  = $this->loginService->authenticate($request->only('email', 'password'));
        $token = $user->createToken('web_api')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function register(): void
    {
        
    }
}