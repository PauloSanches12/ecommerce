<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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

            return $this->userRepository->create($data);
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
            $user = $this->userRepository->findByEmail($data['email']);

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
