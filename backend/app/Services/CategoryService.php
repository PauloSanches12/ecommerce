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

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->all();
    }

    public function createCategory(Request $request): object
    {
        $data = $request->only(['name']);
        return $this->categoryRepository->create($data);
    }

    public function updateCategory(Request $request, int $id): ?object
    {
        $data = $request->only(['name', 'description']);
        return $this->categoryRepository->update($data, $id);
    }

    public function deleteCategory(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }
}
