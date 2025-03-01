<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function all(): Collection;
    public function create(array $data): object;
}