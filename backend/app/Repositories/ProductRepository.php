<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Product::paginate($perPage);
    }

    public function findById(int $id): ?object
    {
        return Product::find($id);
    }

    public function findByCategory(int $categoryId, int $perPage): LengthAwarePaginator
    {
        return Product::where('category_id', $categoryId)->paginate($perPage);
    }

    public function search(string $query, int $perPage): LengthAwarePaginator
    {
        return Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->paginate($perPage);
    }

    public function create(array $data): object
    {
        return Product::create($data);
    }
}
