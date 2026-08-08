<?php

namespace App\Http\Controllers\Api\Storefront;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer' => 'required|array',
            'customer.firstName' => 'required|string',
            'customer.lastName' => 'required|string',
            'customer.email' => 'required|email',
            'customer.phone' => 'required|string',
            'customer.address' => 'required|string',
            'customer.city' => 'required|string',
            'customer.zip' => 'required|string',
            'customer.country' => 'required|string',
            'paymentMethod' => 'required|in:cod,card',
            'couponCode' => 'nullable|string',
        ]);

        $cartToken = $request->header('X-Cart-Token');
        if (! $cartToken) {
            return ApiResponse::error('Cart is empty', 400);
        }

        $cartItems = CartItem::where('cart_token', $cartToken)->get();

        if ($cartItems->isEmpty()) {
            return ApiResponse::error('Cart is empty', 400);
        }

        $subtotal = 0;
        $orderItems = [];

        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if (! $product || $product->stock < $item->qty) {
                return ApiResponse::error("Insufficient stock for {$item->name}", 400);
            }

            $lineTotal = $item->price * $item->qty;
            $subtotal += $lineTotal;

            $orderItems[] = [
                'name' => $item->name,
                'size' => $item->size,
                'qty' => $item->qty,
                'price' => $item->price,
                'image' => $item->image,
            ];

            $product->decrement('stock', $item->qty);
        }

        $settings = Setting::pluck('value', 'key')->toArray();
        $shippingFreeThreshold = $settings['shipping_free_threshold'] ?? 100;
        $shippingCost = $settings['shipping_cost'] ?? 9.99;
        $shipping = $subtotal >= $shippingFreeThreshold ? 0 : $shippingCost;

        $discount = 0;
        if (! empty($validated['couponCode'])) {
            $coupon = Coupon::valid($validated['couponCode'])->first();
            if ($coupon) {
                if ($coupon->type === 'percentage') {
                    $discount = $subtotal * ($coupon->value / 100);
                } else {
                    $discount = $coupon->value;
                }
                $discount = min($discount, $subtotal);
            }
        }

        $total = $subtotal + $shipping - $discount;

        $order = Order::create([
            'id' => 'ORD-' . strtoupper(substr(uniqid(), -8)),
            'customer' => $validated['customer'],
            'items' => $orderItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'discount' => $discount,
            'total' => $total,
            'paymentMethod' => $validated['paymentMethod'],
            'status' => 'pending',
        ]);

        CartItem::where('cart_token', $cartToken)->delete();

        return ApiResponse::success($order, 'Order placed successfully', 201);
    }
}
