<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class PaymentData extends Data
{
    public function __construct(
        // public int $order_id,
        public string $payment_method,
        public float $amount,
        public string $status,
        public string $transaction_id,
        public ?string $payment_link = null,
        public ?string $qr_code = null
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            $data['payment_method'],
            $data['amount'],
            $data['status'],
            $data['transaction_id'],
            $data['payment_link'],
            $data['qr_code'],

        );
    }
}
