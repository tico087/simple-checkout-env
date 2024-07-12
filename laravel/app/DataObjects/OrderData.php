<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public int $customer_id,
        public int $payment_id,
        public string $status
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            customer_id: $data['customer_id'],
            payment_id: $data['payment_id'],
            status: $data['status'],

        );
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            customer_id: $data['customer_id'],
            payment_id: $data['payment_id'],
            status: $data['status'],

        );
    }
}
