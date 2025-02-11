<?php

namespace App\Http\Controllers;

use App\DataObjects\CustomerCreditCardData;
use App\Models\CustomerCreditCard;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerCreditCardController extends Controller
{

    public function store(CustomerCreditCardData $data): JsonResource
    {
        $creditCard = CustomerCreditCard::create($data->toArray());
        return new JsonResource($creditCard);
    }

    public function update(CustomerCreditCardData $data, int $id): JsonResource
    {
        $creditCard = CustomerCreditCard::findOrFail($id);
        $creditCard->update($data->toArray());
        return new JsonResource($creditCard);
    }

    public function destroy(int $id): JsonResource
    {
        $creditCard = CustomerCreditCard::findOrFail($id);
        $creditCard->delete();
        return new JsonResource($creditCard);
    }
}
