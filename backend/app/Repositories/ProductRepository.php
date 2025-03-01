<?php

namespace App\Repositories;

use App\Interfaces\RepositoriesInterface\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    protected function getQuery()
    {
        return Product::with('category');
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return $this->getQuery()->paginate($perPage);
    }

    public function findById(int $id): Product
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function findByCategory(int $categoryId, int $perPage): LengthAwarePaginator
    {
        return $this->getQuery()
            ->where('category_id', $categoryId)
            ->paginate($perPage);
    }

    public function search(string $query, int $perPage): LengthAwarePaginator
    {
        return $this->getQuery()
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->paginate($perPage);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(array $data, int $id): Product
    {
        $product = $this->findById($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id): bool
    {
        return (bool) Product::destroy($id);
    }
}
