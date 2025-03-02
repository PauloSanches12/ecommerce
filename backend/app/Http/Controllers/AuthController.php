<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     *
     * @param  \App\Http\Requests\RegisterUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request)
    {
        $user = $this->authService->register($request->validated());

        return response()->json(['message' => 'Usuário registrado com sucesso', 'user' => $user], Response::HTTP_CREATED);
    }

    /**
     * Login a user.
     *
     * @param  \App\Http\Requests\LoginUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginUserRequest $request)
    {
        $token = $this->authService->login($request->validated());

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], Response::HTTP_OK);
    }

    /**
     * Logout the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Desconectado com sucesso'], Response::HTTP_OK);
    }
}
