<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Order;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected ActivityLogger $logger,
    ) {}

    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->search) {
            $query->search($request->search);
        }

        if ($request->status) {
            $query->status($request->status);
        }

        $orders = $query->latest()->paginate($request->get('per_page', 15));

        return ApiResponse::paginated($orders);
    }

    public function show(Order $order)
    {
        return ApiResponse::success($order);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        $this->logger->order('order.status_updated', $order->id, "Order status changed to {$validated['status']}");

        return ApiResponse::success($order, 'Order status updated successfully');
    }
}
