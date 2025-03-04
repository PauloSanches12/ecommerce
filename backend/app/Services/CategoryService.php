<?php

namespace App\Services;

use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        try {
            return $this->categoryRepository->all();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Create a category
     *
     * @param Request $request
     * @return object
     */
    public function createCategory(Request $request): object
    {
        try {
            $data = $request->only(['name']);
            return $this->categoryRepository->create($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update a category
     *
     * @param Request $request
     * @param integer $id
     * @return object|null
     */
    public function updateCategory(Request $request, int $id): ?object
    {
        try {
            $data = $request->only(['name']);
            return $this->categoryRepository->update($data, $id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete a category
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteCategory(int $id): bool
    {
        try {
            return $this->categoryRepository->delete($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if a category has products
     *
     * @param integer $id
     * @return boolean
     */
    public function hasProducts(int $id): bool
    {
        try {
            return $this->categoryRepository->hasProducts($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
