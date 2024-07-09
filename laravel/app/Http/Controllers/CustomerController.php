<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\DataObjects\CustomerData;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function store(CustomerData $customerData): JsonResponse
    {
        $customer = Customer::create($customerData->toArray());

        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);

        return response()->json([
            'customer' => $customer
        ]);
    }
}
