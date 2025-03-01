<?php

namespace App\Repositories;

use App\Interfaces\RepositoriesInterface\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(): Collection
    {
        return Category::all();
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(array $data, int $id): ?Category
    {
        $category = $this->findCategoryOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id): bool
    {
        $category = $this->findCategoryOrFail($id);
        return $category->delete();
    }

    public function hasProducts(int $id): bool
    {
        $category = $this->findCategoryOrFail($id);
        return $category->products()->exists();
    }

    private function findCategoryOrFail(int $id): ?Category
    {
        return Category::findOrFail($id);
    }
}
