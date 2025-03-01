<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        try {
            $perPage = 10;

            if ($request->has('category')) {
                return response()->json($this->productService->getProductsByCategory($request->category, $perPage));
            }

            if ($request->has('search')) {
                return response()->json($this->productService->searchProducts($request->search, $perPage));
            }

            return response()->json($this->productService->getAllProducts($perPage));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id)
    {
        try {
            return response()->json($this->productService->getProductById($id));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image_url' => 'required|url',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
            ]);
  
            $product = $this->productService->createProduct($request);
            return response()->json($product, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
