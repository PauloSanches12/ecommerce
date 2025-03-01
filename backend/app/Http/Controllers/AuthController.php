<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Interfaces\ServicesInterface\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     *
     * @param  \App\Http\Requests\RegisterUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        return response()->json(['message' => 'Usuário registrado com sucesso', 'user' => $user], Response::HTTP_CREATED);
    }

    /**
     * Login a user.
     *
     * @param LoginUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());
        
        if (!$token) {
            return response()->json(['message' => 'Credenciais inválidas'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], Response::HTTP_OK);
    }

    /**
     * Logout the user.
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        $this->authService->logout($request->user());
    }

    /**
     * Get the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request): JsonResponse
    {
        return response()->json($request->user(), Response::HTTP_OK);
    }
}
