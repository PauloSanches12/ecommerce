<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @return CategoryCollection|JsonResponse
     */
    public function index(): CategoryCollection | JsonResponse
    {
        try {
            $categories = $this->categoryService->getAllCategories();
            return new CategoryCollection($categories);
        } catch (\Exception $e) {
            error_log('Erro ao buscar categorias: ' . $e);
            return response()->json(['error' => 'Erro ao buscar categorias.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a category
     * 
     * @return CategoryResource|JsonResponse
     */
    public function store(CategoryRequest $request): CategoryResource|JsonResponse
    {
        try {
            $request->validated();
            $category = $this->categoryService->createCategory($request);
            return new CategoryResource($category);
        } catch (\Exception $e) {
            error_log('Erro ao criar a categoria: ' . $e);
            return response()->json(['error' => 'Erro ao criar a categoria.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update a category
     * 
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
        } catch (\Exception $e) {
            error_log('Erro ao atualizar a categoria: ' . $e);
            return response()->json(['error' => 'Erro ao atualizar a categoria.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete a category
     *
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
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir a categoria.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
