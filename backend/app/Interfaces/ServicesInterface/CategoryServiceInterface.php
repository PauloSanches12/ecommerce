<?php

namespace App\Interfaces\ServicesInterface;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface CategoryServiceInterface
{
    public function getAllCategories(): Collection;
    public function createCategory(Request $request): Category;
    public function updateCategory(Request $request, int $id): ?Category;
    public function deleteCategory(int $id): bool;
    public function hasProducts(int $id): bool; 
}
