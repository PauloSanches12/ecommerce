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

    /**
     * Get all products
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllProducts(int $perPage): LengthAwarePaginator
    {
        try {
            return $this->productRepository->paginate($perPage);
        } catch (\Exception $e) {
            return new LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Get a product by id
     *
     * @param integer $id
     * @return object|null
     */
    public function getProductById(int $id): ?object
    {
        try {
            return $this->productRepository->findById($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get products by category
     *
     * @param integer $categoryId
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getProductsByCategory(int $categoryId, int $perPage): LengthAwarePaginator
    {
        try {
            return $this->productRepository->findByCategory($categoryId, $perPage);
        } catch (\Exception $e) {
            return new LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Search products
     *
     * @param string $query
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function searchProducts(string $query, int $perPage): LengthAwarePaginator
    {
        try {
            return $this->productRepository->search($query, $perPage);
        } catch (\Exception $e) {
            return new LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Create a product
     *
     * @param Request $request
     * @return object|null
     */
    public function createProduct(Request $request): ?object
    {
        $data = $request->only(['name', 'description', 'image_url', 'price', 'category_id']);
        try {
            return $this->productRepository->create($data);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Update a product
     *
     * @param Request $request
     * @param integer $id
     * @return object|null
     */
    public function updateProduct(Request $request, int $id): ?object
    {
        $data = $request->only(['name', 'description', 'price', 'image_url', 'category_id']);
        try {
            return $this->productRepository->update($data, $id);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Delete a product
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteProduct(int $id): bool
    {
        try {
            return $this->productRepository->delete($id);
        } catch (\Exception $e) {
            return false;
        }
    }
}