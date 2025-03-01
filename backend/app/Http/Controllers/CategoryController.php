<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return response()->json($this->categoryService->getAllCategories());
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $category = $this->categoryService->createCategory($request);
            return response()->json($category, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        // $request->validate([
        //     'name' => 'required|string|max:255',
        // ]);

        // $category = $this->categoryService->createCategory($request);
        // return response()->json($category, 201);
    }
}
