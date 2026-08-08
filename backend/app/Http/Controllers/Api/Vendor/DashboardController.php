<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Product;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $revenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();

        return ApiResponse::success([
            'total_products' => $totalProducts,
            'total_orders' => $totalOrders,
            'revenue' => (float) $revenue,
            'pending_orders' => $pendingOrders,
        ]);
    }

    public function recentOrders()
    {
        $orders = Order::latest()->take(5)->get();

        return ApiResponse::success($orders);
    }

    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return ApiResponse::success($settings);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'sometimes|string',
            'currency' => 'sometimes|string',
            'currency_symbol' => 'sometimes|string',
            'shipping_free_threshold' => 'sometimes|numeric|min:0',
            'shipping_cost' => 'sometimes|numeric|min:0',
            'tax_rate' => 'sometimes|numeric|min:0|max:100',
            'whatsapp' => 'nullable|string',
            'email' => 'nullable|email',
            'announcement_text' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return ApiResponse::success(null, 'Settings updated successfully');
    }
}
