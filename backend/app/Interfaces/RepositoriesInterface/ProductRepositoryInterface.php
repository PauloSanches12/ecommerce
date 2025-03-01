<?php

namespace App\Interfaces\RepositoriesInterface;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator;
    public function findById(int $id): ?object;
    public function findByCategory(int $categoryId, int $perPage): LengthAwarePaginator;
    public function search(string $query, int $perPage): LengthAwarePaginator;
    public function create(array $data): object;
    public function update(array $data, int $id): ?object;
    public function delete(int $id): bool;
}