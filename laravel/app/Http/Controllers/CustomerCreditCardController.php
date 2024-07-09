<?php

namespace App\Http\Controllers;

use App\Models\CustomerCreditCard;
use App\DataObjects\CustomerCreditCardData;
use Illuminate\Http\JsonResponse;

class CustomerCreditCardController extends Controller
{
    public function store(CustomerCreditCardData $customerCreditCardData): JsonResponse
    {
        $creditCard = CustomerCreditCard::create($customerCreditCardData->toArray());

        return response()->json([
            'message' => 'Credit card added successfully',
            'credit_card' => $creditCard
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $creditCard = CustomerCreditCard::findOrFail($id);

        return response()->json([
            'credit_card' => $creditCard
        ]);
    }
}
