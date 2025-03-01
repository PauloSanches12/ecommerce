<?php

namespace App\Services;

use App\Interfaces\RepositoriesInterface\CategoryRepositoryInterface;
use App\Interfaces\ServicesInterface\CategoryServiceInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CategoryService implements CategoryServiceInterface
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
        return $this->categoryRepository->all();
    }

    /**
     * Create a category
     *
     * @param Request $request
     * @return Category
     */
    public function createCategory(Request $request): Category
    {
        $data = $request->only(['name']);

        return $this->categoryRepository->create($data);
    }

    /**
     * Update a category
     *
     * @param Request $request
     * @param integer $id
     * @return Category|null
     */
    public function updateCategory(Request $request, int $id): ?Category
    {
        $data = $request->only(['name']);
        return $this->categoryRepository->update($data, $id);
    }

    /**
     * Delete a category
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteCategory(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }

    /**
     * Check if a category has products
     *
     * @param integer $id
     * @return boolean
     */
    public function hasProducts(int $id): bool
    {
        return $this->categoryRepository->hasProducts($id);
    }
}
