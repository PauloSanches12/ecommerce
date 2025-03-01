<?php

namespace App\Interfaces\ServicesInterface;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): User;
    public function login(array $data): string|bool;
    public function logout(User $user): void;
}
