<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    /**
     * Get all products (API)
     */
    public function getProducts(): JsonResponse
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    /**
     * Create a new product (API - manager/admin only)
     */
    public function createProduct(Request $request)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'Category_id' => 'required|exists:categories,id',
            'pricing' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|array',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    /**
     * Get a specific product (API)
     */
    public function getProduct(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update a product (API - manager/admin only)
     */
    public function updateProduct(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'Category_id' => 'required|exists:categories,id',
            'pricing' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|array',
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    /**
     * Delete a product (API - manager/admin only)
     */
    public function deleteProduct(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);
        
        $product->delete();
        return response()->json(null, 204);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'Category_id' => 'required|exists:categories,id',
            'pricing' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|array',
        ]);

        $this->authorize('create', Product::class);
        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'Category_id' => 'required|exists:categories,id',
            'pricing' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|array',
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);
        
        $product->delete();
        return response()->json(null, 204);
    }
}
