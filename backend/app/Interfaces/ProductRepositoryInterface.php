<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator;
    public function findById(int $id): ?object;
    public function findByCategory(int $categoryId, int $perPage): LengthAwarePaginator;
    public function search(string $query, int $perPage): LengthAwarePaginator;
    public function create(array $data): object;
}