<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public int $customer_id,
        public int $payment_id,
        public float $total_amount,
        public string $status
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            $data['customer_id'],
            $data['payment_id'],
            $data['total_amount'],
            $data['status'],

        );
    }
}
