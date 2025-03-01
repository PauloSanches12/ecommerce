<?php

namespace App\Services;

use App\Interfaces\RepositoriesInterface\AuthRepositoryInterface;
use App\Interfaces\ServicesInterface\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthService implements AuthServiceInterface
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Register a new user.
     *
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return $this->authRepository->create($data);
    }

    /**
     * Login the user.
     *
     * @param array $data
     * @return string|boolean
     */
    public function login(array $data): string|bool
    {
        $user = $this->authRepository->findByEmail($data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return false;
        }

        return $user->createToken('auth_token')->plainTextToken;
    }

    /**
     * Logout the user.
     *
     * @param User $user
     * @return void
     */
    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
}
