<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(): Collection
    {
        return Category::all();
    }

    public function create(array $data): object
    {
        return Category::create($data);
    }

    public function update(array $data, int $id): ?object
    {
        $category = Category::find($id);
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $category = Category::find($id);
        if ($category) {
            return $category->delete();
        }
        return false;
    }

    public function hasProducts($id): bool
    {
        $category = Category::find($id);
        if ($category) {
            return $category->hasProducts();
        }
        return false;
    }
}
