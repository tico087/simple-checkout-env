<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class PaymentData extends Data
{
    public function __construct(
        public string $payment_method,
        public float $amount,
        public string $status,
        public string $transaction_id,
        public ?string $payment_link,
        public ?string $qr_code,
        public ?int $customer_credit_card_id,
        public int $order_id,
        public array $form_request,
        public ?array $api_request,
        public ?array $api_response
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['payment_method'],
            $data['amount'],
            $data['status'],
            $data['transaction_id'],
            $data['payment_link'] ?? null,
            $data['qr_code'] ?? null,
            $data['customer_credit_card_id'] ?? null,
            $data['order_id'],
            $data['form_request'],
            $data['api_request'] ?? null,
            $data['api_response'] ?? null
        );
    }
}
