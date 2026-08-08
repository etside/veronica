<?php

use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ApiResponse::success([
        'name' => 'Veronica API',
        'version' => '1.0.0',
        'status' => 'running',
    ]);
});
