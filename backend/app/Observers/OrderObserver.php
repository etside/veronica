<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\ActivityLogger;

class OrderObserver
{
    public function __construct(
        protected ActivityLogger $logger,
    ) {}

    public function created(Order $order): void
    {
        $this->logger->order('order.created', $order->id, "Order \"{$order->id}\" placed");
    }

    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {
            $this->logger->order('order.status_changed', $order->id, "Order status changed to {$order->status}");
        }
    }

    public function deleted(Order $order): void
    {
        $this->logger->order('order.deleted', $order->id, "Order \"{$order->id}\" deleted");
    }
}
