<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;
use App\DataObjects\CustomerData;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

class PaymentData extends Data
{
    public function __construct(
        public string $customer_api_id,
        public string $payment_method,
        public float $amount,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public Carbon $due_date,
        public ?string $status,
        public ?string $transaction_id,
        public ?string $payment_link,
        public ?string $qr_code,
        public ?int $customer_credit_card_id,
        public ?int $order_id,
        public array $form_request,
        public ?array $api_request,
        public ?array $api_response,


    ) {}

    public static function fromArray(array $data): static
    {

        return new static(
            customer_api_id : $data['customer_api_id'],
            payment_method : $data['payment_method'],
            amount: $data['amount'],
            status: $data['status'],
            due_date: Carbon::createFromFormat('Y-m-d', $data['due_date']),
            transaction_id: $data['transaction_id'],
            payment_link: $data['payment_link'] ?? null,
            qr_code: $data['qr_code'] ?? null,
            customer_credit_card_id: $data['customer_credit_card_id'] ?? null,
            order_id: $data['order_id'],
            form_request: $data['form_request'],
            api_request: $data['api_request'] ?? null,
            api_response : $data['api_response'] ?? null,

        );
    }
}
