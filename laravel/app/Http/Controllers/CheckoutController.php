<?php

namespace App\Http\Controllers;


use App\Services\PaymentService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;
use JsonException;
use App\DataObjects\PaymentData;

class CheckoutController extends Controller
{


    public function __construct(protected PaymentService $service)
    {
    }

    public function index(): View
    {
        return view('checkout');
    }

    public function process(PaymentData $data): JsonResource
    {

        // try{
            // $customer = $this->service->createApiCustomer($data->customer);
            $payment = $this->service->createApiPayment($data);
            return new JsonResource($payment);
        // }catch (JsonException){
            // return response()->json(['errors' => $customer['errors']], 400);
        // }


    }

    public function thankYou(int $orderId): JsonResource
    {
        $order = $this->service->getApiPayment($orderId);
        return new JsonResource($order);
    }
}
