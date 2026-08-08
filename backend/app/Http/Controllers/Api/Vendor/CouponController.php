<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Coupon;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(
        protected ActivityLogger $logger,
    ) {}

    public function index()
    {
        $coupons = Coupon::latest()->get();

        return ApiResponse::success($coupons);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $validated['is_active'] ?? true;

        $coupon = Coupon::create($validated);

        $this->logger->log('coupon.created', auth()->id(), "Coupon \"{$coupon->code}\" created");

        return ApiResponse::success($coupon, 'Coupon created successfully', 201);
    }

    public function show(Coupon $coupon)
    {
        return ApiResponse::success($coupon);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'sometimes|required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'sometimes|required|in:percentage,fixed',
            'value' => 'sometimes|required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        if (isset($validated['code'])) {
            $validated['code'] = strtoupper($validated['code']);
        }

        $coupon->update($validated);

        $this->logger->log('coupon.updated', auth()->id(), "Coupon \"{$coupon->code}\" updated");

        return ApiResponse::success($coupon, 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon)
    {
        $code = $coupon->code;
        $coupon->delete();

        $this->logger->log('coupon.deleted', auth()->id(), "Coupon \"{$code}\" deleted");

        return ApiResponse::success(null, 'Coupon deleted successfully');
    }
}
