<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function create(array $data): User;
    public function findByEmail(string $email): ?User;
}