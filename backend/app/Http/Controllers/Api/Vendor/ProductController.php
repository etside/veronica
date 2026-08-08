<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Product;
use App\Models\Category;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(
        protected ActivityLogger $logger,
    ) {}

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->search($request->search);
        }

        if ($request->category && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate($request->get('per_page', 15));

        return ApiResponse::paginated($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'image' => 'required|string',
            'images' => 'nullable|array',
            'sizes' => 'nullable|array',
            'badge' => 'nullable|string',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,draft,archived',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        $product = Product::create($validated);

        $this->logger->product('product.created', $product->id, "Product \"{$product->name}\" created");

        return ApiResponse::success($product, 'Product created successfully', 201);
    }

    public function show(Product $product)
    {
        return ApiResponse::success($product);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|unique:products,slug,' . $product->id,
            'price' => 'sometimes|required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'stock' => 'sometimes|required|integer|min:0',
            'image' => 'sometimes|required|string',
            'images' => 'nullable|array',
            'sizes' => 'nullable|array',
            'badge' => 'nullable|string',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,draft,archived',
        ]);

        $product->update($validated);

        $this->logger->product('product.updated', $product->id, "Product \"{$product->name}\" updated");

        return ApiResponse::success($product, 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        $this->logger->product('product.deleted', $product->id, "Product \"{$name}\" deleted");

        return ApiResponse::success(null, 'Product deleted successfully');
    }

    public function categories()
    {
        $categories = Category::orderBy('name')->get();

        return ApiResponse::success($categories);
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);

        return ApiResponse::success($category, 'Category created successfully', 201);
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();

        return ApiResponse::success(null, 'Category deleted successfully');
    }
}
