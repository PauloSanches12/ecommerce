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
}
