<?php

namespace App\Http\Controllers;

use App\DataObjects\OrderData;
use App\Services\PaymentService;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutController extends Controller
{


    public function __construct( protected PaymentService $paymentService)
    {
    }

    public function checkout(OrderData $data): JsonResource
    {
        $order = $this->paymentService->processOrder($data);
        return new JsonResource($order);
    }

    public function thankYou(int $orderId): JsonResource
    {
        $order = $this->paymentService->getOrderDetails($orderId);
        return new JsonResource($order);
    }
}
