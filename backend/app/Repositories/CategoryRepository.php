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
}
