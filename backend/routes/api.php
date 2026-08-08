<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Vendor\AuthController;
use App\Http\Controllers\Api\Vendor\ProductController;
use App\Http\Controllers\Api\Vendor\OrderController;
use App\Http\Controllers\Api\Vendor\DashboardController;
use App\Http\Controllers\Api\Vendor\CouponController;
use App\Http\Controllers\Api\Storefront\ProductController as StorefrontProductController;
use App\Http\Controllers\Api\Storefront\CartController;
use App\Http\Controllers\Api\Storefront\CheckoutController;
use App\Http\Controllers\Api\Storefront\OrderController as StorefrontOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Storefront Routes (Public)
Route::prefix('store')->group(function () {
    // Products
    Route::get('/products', [StorefrontProductController::class, 'index']);
    Route::get('/products/{slug}', [StorefrontProductController::class, 'show']);
    Route::get('/categories', [StorefrontProductController::class, 'categories']);

    // Cart
    Route::post('/cart', [CartController::class, 'store']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::delete('/cart', [CartController::class, 'clear']);

    // Checkout
    Route::post('/checkout', [CheckoutController::class, 'store']);

    // Orders
    Route::get('/orders/{id}', [StorefrontOrderController::class, 'show']);
});

// Vendor/Admin Routes (Authenticated)
Route::prefix('vendor')->group(function () {
    // Auth
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // Dashboard
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
        Route::get('/dashboard/recent-orders', [DashboardController::class, 'recentOrders']);

        // Products
        Route::apiResource('products', ProductController::class);

        // Orders
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{id}', [OrderController::class, 'show']);
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);

        // Categories
        Route::get('/categories', [ProductController::class, 'categories']);
        Route::post('/categories', [ProductController::class, 'storeCategory']);
        Route::delete('/categories/{id}', [ProductController::class, 'destroyCategory']);

        // Coupons
        Route::get('/coupons', [CouponController::class, 'index']);
        Route::post('/coupons', [CouponController::class, 'store']);
        Route::get('/coupons/{coupon}', [CouponController::class, 'show']);
        Route::put('/coupons/{coupon}', [CouponController::class, 'update']);
        Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy']);

        // Settings
        Route::get('/settings', [DashboardController::class, 'settings']);
        Route::put('/settings', [DashboardController::class, 'updateSettings']);
    });
});
