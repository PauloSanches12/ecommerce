<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function all(): Collection;
    public function create(array $data): object;
    public function update(array $data, int $id): ?object;
    public function delete(int $id): bool;
    public function hasProducts($id): bool;
}