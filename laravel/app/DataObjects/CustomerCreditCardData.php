<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;
use App\DataObjects\CustomerAddressData;

class CustomerCreditCardData extends Data
{
    public function __construct(
        public int $customer_id,
        public string $last_numbers,
        public ?string $brand,
        public ?string $expiry_date,
        public ?string $card_holder_name,
        public ?string $token,

    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            customer_id: $data['customer_id'],
            last_numbers: $data['last_numbers'],
            brand: $data['brand'] ?? null,
            expiry_date: $data['expiry_date'] ?? null,
            card_holder_name: $data['card_holder_name'] ?? null,
            token: $data['token'] ?? null,
        );
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            customer_id: $data['customer_id'],
            last_numbers: $data['creditCardNumber'],
            brand: $data['creditCardBrand'] ?? null,
            expiry_date: $data['expiry_date'] ?? null,
            card_holder_name: $data['card_holder_name'] ?? null,
            token: $data['creditCardToken'] ?? null,
        );
    }

}
