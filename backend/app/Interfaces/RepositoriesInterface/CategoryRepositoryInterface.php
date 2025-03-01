<?php

namespace App\Interfaces\RepositoriesInterface;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function all(): Collection;
    public function create(array $data): Category;
    public function update(array $data, int $id): ?Category;
    public function delete(int $id): bool;
    public function hasProducts(int $id): bool;
}