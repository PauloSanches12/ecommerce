<?php

namespace App\Interfaces\ServicesInterface;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function getAllProducts(int $perPage): LengthAwarePaginator;
    public function getProductById(int $id): object;
    public function getProductsByCategory(int $categoryId, int $perPage): LengthAwarePaginator;
    public function searchProducts(string $query, int $perPage): LengthAwarePaginator;
    public function createProduct(Request $request): object;
    public function updateProduct(Request $request, int $id): object;
    public function deleteProduct(int $id): bool;
}
