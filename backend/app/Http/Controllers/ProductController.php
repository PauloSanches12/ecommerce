<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
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
        try {
            $perPage = 10;

            if ($request->has('category')) {
                $products = $this->productService->getProductsByCategory($request->category, $perPage);
                return new ProductCollection($products);
            }

            if ($request->has('search')) {
                $products = $this->productService->searchProducts($request->search, $perPage);
                return new ProductCollection($products);
            }

            $products = $this->productService->getAllProducts($perPage);
            return new ProductCollection($products);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
            $product = $this->productService->getProductById($id);

            if (!$product) {
                return response()->json(['message' => 'Produto não encontrado'], Response::HTTP_NOT_FOUND);
            }

            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a product
     * 
     * @param ProductRequest $request
     * @return ProductResource|JsonResponse
     */
    public function store(ProductRequest $request): ProductResource|JsonResponse
    {
        try {
            $request->validated();

            $product = $this->productService->createProduct($request);

            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
            $request->validated();

            $product = $this->productService->updateProduct($request, $id);
            if (!$product) {
                return response()->json(['error' => 'Produto não encontrado.'], Response::HTTP_NOT_FOUND);
            }

            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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
        try {
            $deleted = $this->productService->deleteProduct($id);
            if (!$deleted) {
                return response()->json(['error' => 'Produto não encontrado.'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}