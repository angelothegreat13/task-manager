<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Services\Auth\LoginService;
use App\Services\Auth\RegisterService;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\V1\UserResource;

class AuthApiController extends Controller
{
    public function __construct(
        private readonly LoginService $loginService,
        private readonly RegisterService $registerService,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $user  = $this->loginService->authenticate($request->only('email', 'password'));
        $token = $user->createToken('web_api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'data'  => new UserResource($user),
        ]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user  = $this->registerService->handle($request->validated());
        $token = $user->createToken('web_api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'data'  => new UserResource($user),
        ], 201);
    }
}