<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ActivityLogger
{
    public function log(string $action, ?int $userId = null, ?string $description = null, ?array $properties = []): void
    {
        Log::info('Activity', [
            'action' => $action,
            'user_id' => $userId,
            'description' => $description,
            'properties' => $properties,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function product(string $action, ?int $productId = null, ?string $description = null): void
    {
        $this->log($action, auth()->id(), $description, ['product_id' => $productId]);
    }

    public function order(string $action, ?int $orderId = null, ?string $description = null): void
    {
        $this->log($action, auth()->id(), $description, ['order_id' => $orderId]);
    }
}
