<?php

namespace App\Services;

use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Register a new user.
     *
     * @param  array  $data
     * @return \App\Models\User
     * @throws \Exception
     */
    public function register(array $data): User
    {
        try {
            $data['password'] = Hash::make($data['password']);

            return $this->authRepository->create($data);
        } catch (\Exception $e) {
            throw new \Exception('Erro ao registrar o usuário: ' . $e->getMessage());
        }
    }

    /**
     * Login a user.
     *
     * @param  array  $data
     * @return string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(array $data): string|bool
    {
        try {
            $user = $this->authRepository->findByEmail($data['email']);

            if (! $user || ! Hash::check($data['password'], $user->password)) {
                return false;
            }

            return $user->createToken('auth_token')->plainTextToken;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao fazer login: ' . $e->getMessage());
        }
    }

    /**
     * Logout the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     * @throws \Exception
     */
    public function logout(User $user): void
    {
        try {
            $user->tokens()->delete();
        } catch (\Exception $e) {
            throw new \Exception('Erro ao fazer logout: ' . $e->getMessage());
        }
    }
}
