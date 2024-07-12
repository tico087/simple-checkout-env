<?php

namespace App\Http\Controllers;

use App\DataObjects\CustomerData;
use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerController extends Controller
{

    public function store(CustomerData $data): JsonResource
    {
        $customer = Customer::create($data->toArray());
        return new JsonResource($customer);
    }

    public function update(CustomerData $data, int $id): JsonResource
    {
        $customer = Customer::findOrFail($id);
        $customer->update($data->toArray());
        return new JsonResource($customer);
    }

    // @todo verify if exists
    // public function storeOrUpdate(CustomerData $data, $refer='id', $param = null): JsonResource
    // {
    //     $customer = Customer::create($data->toArray());
    //     return new JsonResource($customer);
    // }

}
