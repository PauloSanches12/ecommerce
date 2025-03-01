<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Interfaces\ServicesInterface\ProductServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Get all products
     *
     * @param Request $request
     * @return ProductCollection|JsonResponse
     */
    public function index(Request $request): ProductCollection|JsonResponse
    {
        $perPage = 12;

        if ($request->has('category')) {
            return new ProductCollection($this->productService->getProductsByCategory($request->category, $perPage));
        }

        if ($request->has('search')) {
            return new ProductCollection($this->productService->searchProducts($request->search, $perPage));
        }

        return new ProductCollection($this->productService->getAllProducts($perPage));
    }

    /**
     * Get a product by id
     * 
     * @param int $id
     * @return ProductResource|JsonResponse
     */
    public function show(int $id): ProductResource|JsonResponse
    {
        try {
            return new ProductResource($this->productService->getProductById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Produto não encontrado'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Create a product
     * 
     * @param ProductRequest $request
     * @return ProductResource
     */
    public function store(ProductRequest $request): ProductResource
    {
        return new ProductResource($this->productService->createProduct($request));
    }

    /**
     * Update a product
     * 
     * @param ProductRequest $request
     * @param int $id
     * @return ProductResource|JsonResponse
     */
    public function update(ProductRequest $request, int $id): ProductResource|JsonResponse
    {
        try {
            return new ProductResource($this->productService->updateProduct($request, $id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Produto não encontrado.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Delete a product
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->productService->deleteProduct($id)) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        return response()->json(['message' => 'Produto não encontrado.'], Response::HTTP_NOT_FOUND);
    }
}