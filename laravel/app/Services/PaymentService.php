<?php

namespace App\Services;

use App\DataObjects\OrderData;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    public function processOrder(OrderData $data): Order
    {
        $order = Order::create($data->toArray());
        return $order;
    }

    public function getOrderDetails(int $orderId): Order
    {
        return Order::findOrFail($orderId);
    }

    public function processPayment(PaymentData $data): Payment
    {
        $payment = Payment::create($data->toArray());
        // Process payment with Asaas API
        return $payment;
    }
}
