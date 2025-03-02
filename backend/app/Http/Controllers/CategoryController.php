<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get all categories
     *
     * @return ProductResource|JsonResponse
     */
    public function index(): CategoryCollection | JsonResponse
    {
        try {
            $categories = $this->categoryService->getAllCategories();
            return new CategoryCollection($categories);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a category
     *
     * @param CategoryRequest $request
     * @return CategoryResource|JsonResponse
     */
    public function store(CategoryRequest $request): CategoryResource|JsonResponse
    {
        try {
            $request->validated();

            $category = $this->categoryService->createCategory($request);
            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a category by id
     *
     * @param CategoryRequest $request
     * @param integer $id
     * @return CategoryResource|JsonResponse
     */
    public function update(CategoryRequest $request, int $id): CategoryResource|JsonResponse
    {
        try {
            $request->validated();

            $category = $this->categoryService->updateCategory($request, $id);
            if (!$category) {
                return response()->json(['error' => 'Categoria não encontrada.'], Response::HTTP_NOT_FOUND);
            }

            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete a category
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->categoryService->deleteCategory($id);
            if (!$deleted) {
                return response()->json(['error' => 'Categoria não encontrada.'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
