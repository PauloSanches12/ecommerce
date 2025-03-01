<?php

namespace App\Services;

use App\Interfaces\RepositoriesInterface\ProductRepositoryInterface;
use App\Interfaces\ServicesInterface\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get all products
     * @return LengthAwarePaginator
     */
    public function getAllProducts(int $perPage): LengthAwarePaginator
    {
        return $this->productRepository->paginate($perPage);
    }

    /**
     * Get a product by id
     *
     * @param integer $id
     * @return object
     */
    public function getProductById(int $id): object
    {
        return $this->productRepository->findById($id);
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
        return $this->productRepository->findByCategory($categoryId, $perPage);
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
        return $this->productRepository->search($query, $perPage);
    }

    /**
     * Create a product
     *
     * @param Request $request
     * @return object
     */
    public function createProduct(Request $request): object
    {
        return $this->productRepository->create($request->all());
    }

    /**
     * Update a product
     *
     * @param Request $request
     * @param integer $id
     * @return object
     */
    public function updateProduct(Request $request, int $id): object
    {
        return $this->productRepository->update($request->all(), $id);
    }

    /**
     * Delete a product
     *
     * @param integer $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }
}