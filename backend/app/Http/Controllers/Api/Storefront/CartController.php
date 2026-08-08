<?php

namespace App\Http\Controllers\Api\Storefront;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartToken = $request->header('X-Cart-Token');

        if (! $cartToken) {
            return ApiResponse::success([]);
        }

        $items = CartItem::where('cart_token', $cartToken)
            ->with('product')
            ->get();

        return ApiResponse::success($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'qty' => 'nullable|integer|min:1',
        ]);

        $cartToken = $request->header('X-Cart-Token');
        if (! $cartToken) {
            $cartToken = \Str::random(40);
        }

        $product = Product::findOrFail($validated['product_id']);

        $existingItem = CartItem::where('cart_token', $cartToken)
            ->where('product_id', $validated['product_id'])
            ->where('size', $validated['size'])
            ->first();

        if ($existingItem) {
            $existingItem->increment('qty', $validated['qty'] ?? 1);
            $item = $existingItem;
        } else {
            $item = CartItem::create([
                'cart_token' => $cartToken,
                'product_id' => $validated['product_id'],
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'size' => $validated['size'],
                'qty' => $validated['qty'] ?? 1,
            ]);
        }

        return ApiResponse::success([
            'item' => $item->load('product'),
            'cart_token' => $cartToken,
        ], 'Item added to cart', 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:0',
        ]);

        $item = CartItem::findOrFail($id);

        if ($validated['qty'] <= 0) {
            $item->delete();
        } else {
            $item->update(['qty' => $validated['qty']]);
        }

        return ApiResponse::success(null, 'Cart updated');
    }

    public function destroy(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);
        $item->delete();

        return ApiResponse::success(null, 'Item removed from cart');
    }

    public function clear(Request $request)
    {
        $cartToken = $request->header('X-Cart-Token');

        if ($cartToken) {
            CartItem::where('cart_token', $cartToken)->delete();
        }

        return ApiResponse::success(null, 'Cart cleared');
    }
}
