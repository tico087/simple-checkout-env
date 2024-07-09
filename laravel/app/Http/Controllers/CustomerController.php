<?php

namespace App\Http\Controllers;

use App\DataObjects\CustomerData;
use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerController extends Controller
{
    // public function index(): JsonResource
    // {
    //     return JsonResource::collection(Customer::all());
    // }

    public function store(CustomerData $data): JsonResource
    {
        $customer = Customer::create($data->toArray());
        return new JsonResource($customer);
    }

    // public function show(int $id): JsonResource
    // {
    //     return new JsonResource(Customer::findOrFail($id));
    // }

    public function update(CustomerData $data, int $id): JsonResource
    {
        $customer = Customer::findOrFail($id);
        $customer->update($data->toArray());
        return new JsonResource($customer);
    }

    // public function destroy(int $id): JsonResource
    // {
    //     $customer = Customer::findOrFail($id);
    //     $customer->delete();
    //     return new JsonResource($customer);
    // }
}
