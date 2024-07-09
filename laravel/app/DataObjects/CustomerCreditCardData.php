<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class CustomerCreditCardData extends Data
{
    public function __construct(
        public int $customer_id,
        public string $card_number,
        public string $expiry_date,
        public string $card_holder_name
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            $data['customer_id'],
            $data['card_number'],
            $data['expiry_date'],
            $data['card_holder_name'],

        );
    }
}
