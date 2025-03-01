<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $perPage = 10;

        if ($request->has('category')) {
            return response()->json($this->productService->getProductsByCategory($request->category, $perPage));
        }

        if ($request->has('search')) {
            return response()->json($this->productService->searchProducts($request->search, $perPage));
        }

        return response()->json($this->productService->getAllProducts($perPage));
    }

    public function show($id)
    {
        return response()->json($this->productService->getProductById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = $this->productService->createProduct($request);
        return response()->json($product, 201);
    }
}
