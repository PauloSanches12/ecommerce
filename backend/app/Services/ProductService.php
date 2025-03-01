<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(int $perPage): LengthAwarePaginator
    {
        return $this->productRepository->paginate($perPage);
    }

    public function getProductById(int $id): ?object
    {
        return $this->productRepository->findById($id);
    }

    public function getProductsByCategory(int $categoryId, int $perPage): LengthAwarePaginator
    {
        return $this->productRepository->findByCategory($categoryId, $perPage);
    }

    public function searchProducts(string $query, int $perPage): LengthAwarePaginator
    {
        return $this->productRepository->search($query, $perPage);
    }

    public function createProduct(Request $request): object
    {
        $data = $request->only(['name', 'description', 'price', 'category_id']);
        return $this->productRepository->create($data);
    }
}