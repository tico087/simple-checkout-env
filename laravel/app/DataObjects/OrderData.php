<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public int $customer_id,
        public string $status
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            customer_id: $data['customer_id'],
            status: $data['status'],

        );
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            customer_id: $data['customer_id'],
            status: $data['status'],

        );
    }
}
