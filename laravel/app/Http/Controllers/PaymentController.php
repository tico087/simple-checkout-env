<?php

namespace App\Http\Controllers;

use App\DataObjects\PaymentData;
use App\Models\Payment;
use Illuminate\Http\Request;
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


}

