<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\DataObjects\OrderData;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function store(OrderData $orderData): JsonResponse
    {
        $order = Order::create($orderData->toArray());

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        return response()->json([
            'order' => $order
        ]);
    }
}
