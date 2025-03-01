<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Interfaces\ServicesInterface\CategoryServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get all categories
     * 
     * @return CategoryCollection
     */
    public function index(): CategoryCollection
    {
        $categories = $this->categoryService->getAllCategories();

        return new CategoryCollection($categories);
    }

    /**
     * Create a category
     * 
     * @param CategoryRequest $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request): CategoryResource
    {
        $request->validated();
        $category = $this->categoryService->createCategory($request);

        return new CategoryResource($category);
    }

    /**
     * Update a category
     * 
     * @param CategoryRequest $request
     * @param int $id
     * @return CategoryResource|JsonResponse
     */
    public function update(CategoryRequest $request, int $id): CategoryResource|JsonResponse
    {
        try {
            $request->validated();
            $category = $this->categoryService->updateCategory($request, $id);
            return new CategoryResource($category);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Categoria não encontrada.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Delete a category
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $hasProducts = $this->categoryService->hasProducts($id);
            if ($hasProducts) {
                return response()->json(['message' => 'Categoria não pode ser excluída, pois possui produtos associados.'], Response::HTTP_CONFLICT);
            }

            $this->categoryService->deleteCategory($id);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Categoria não encontrada.'], Response::HTTP_NOT_FOUND);
        }
    }
}
