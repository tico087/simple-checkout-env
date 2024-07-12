<?php

namespace App\Http\Controllers;

use App\DataObjects\CustomerAddressData;
use App\Models\CustomerAddress;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerAddressController extends Controller
{

    public function store(CustomerAddressData $data): JsonResource
    {
        $address = CustomerAddress::create($data->toArray());
        return new JsonResource($address);
    }


    public function update(CustomerAddressData $data, int $id): JsonResource
    {
        $address = CustomerAddress::findOrFail($id);
        $address->update($data->toArray());
        return new JsonResource($address);
    }

}
