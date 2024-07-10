<?php

namespace App\Http\Controllers;

use App\DataObjects\OrderData;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends Controller
{
    public function index(): JsonResource
    {
        return JsonResource::collection(Order::all());
    }

    public function store(OrderData $data): JsonResource
    {
        $order = Order::create($data->toArray());
        return new JsonResource($order);
    }

    public function show(int $id): JsonResource
    {
        return new JsonResource(Order::findOrFail($id));
    }


