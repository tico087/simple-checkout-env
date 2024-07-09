<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\DataObjects\PaymentData;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function store(PaymentData $paymentData): JsonResponse
    {
        $payment = Payment::create($paymentData->toArray());

        return response()->json([
            'message' => 'Pagamento Criado com sucesso!',
            'payment' => $payment
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $payment = Payment::findOrFail($id);

        return response()->json([
            'payment' => $payment
        ]);
    }
}
