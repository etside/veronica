<?php

namespace App\Http\Controllers\Api\Storefront;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'active');

        if ($request->search) {
            $query->search($request->search);
        }

        if ($request->category && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate($request->get('per_page', 12));

        return ApiResponse::paginated($products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('status', 'active')->firstOrFail();

        return ApiResponse::success($product);
    }

    public function categories()
    {
        $categories = Category::orderBy('name')->get();

        return ApiResponse::success($categories);
    }
}
