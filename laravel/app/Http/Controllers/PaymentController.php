<?php

namespace App\Http\Controllers;

use App\DataObjects\{PaymentData, OrderData};
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentController extends Controller
{
    public function store(PaymentData $data, int $orderId): JsonResource
    {
        $data = array_merge($data->toArray(), ["order_id" => $orderId]);
        $payment = Payment::create($data);
        return new JsonResource($payment);
    }

    public function update(PaymentData $data, int $id): JsonResource
    {
        $payment = Payment::findOrFail($id);
        $payment->update($data->toArray());
        return new JsonResource($payment);
    }

    public function processSuccessfulPayment(PaymentData $paymentResponseData): void
    {
        $payment = $paymentResponseData->toArray();
        $orderData = OrderData::fromResponse(['status'=> $payment['status'], 'customer_id' => $payment['customer_id']]);
        $order = app(OrderController::class)->store($orderData);
        $this->store($paymentResponseData, $order->id);
    }
}
