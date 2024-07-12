<?php

namespace App\Http\Controllers;

use App\DataObjects\PaymentData;
use App\Models\{Payment, Customer, CustomerAddress, CustomerCreditCard, Order};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentController extends Controller
{
    public function store(PaymentData $data): JsonResource
    {
        $payment = Payment::create($data->toArray());
        return new JsonResource($payment);
    }

    public function update(PaymentData $data, int $id): JsonResource
    {
        $payment = Payment::findOrFail($id);
        $payment->update($data->toArray());
        return new JsonResource($payment);
    }

    public function processSuccessfulPayment(PaymentData $paymentResponseData): JsonResponse
    {

        $customerData = $paymentResponseData->toCustomerData();
        $customer = Customer::create($customerData->toArray());

        $addressData = $paymentResponseData->toCustomerAddressData($customer->id);
        CustomerAddress::create($addressData->toArray());

        $creditCardData = $paymentResponseData->toCustomerCreditCardData($customer->id);
        if ($creditCardData) {
            CustomerCreditCard::create($creditCardData->toArray());
        }

        $orderData = $paymentResponseData->toOrderData($customer->id);
        $order = Order::create($orderData->toArray());

        $paymentData = $paymentResponseData->toPaymentData($order->id);
        Payment::create($paymentData->toArray());

        return new JsonResponse(['success' => true]);
    }
}
