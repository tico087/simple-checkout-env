<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;
use App\DataObjects\{CustomerData, CustomerCreditCardData};
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

class PaymentData extends Data
{
    public function __construct(
        public string $customer_api_id,
        public string $payment_method,
        public float $amount,
        public ?string $description,
        public ?string $external_reference,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public Carbon $due_date,
        public ?float $total_value,
        public ?int $installments,
        public ?string $status,
        public ?string $transaction_id,
        public ?string $payment_link,
        public ?string $qr_code,
        public ?int $customer_credit_card_id,
        public ?int $order_id,
        public array $form_request,
        public ?array $api_request,
        public ?array $api_response,
        public ?array $credit_card,
        public ?array $credit_card_holder,



    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            customer_api_id : $data['customer_api_id'],
            payment_method : $data['payment_method'],
            amount: $data['amount'],
            description: $data['description'] ?? null,
            external_reference: $data['external_reference'] ?? null,
            due_date: Carbon::createFromFormat('Y-m-d', $data['due_date']),
            status:  $data['transaction_id'],
            total_value : $data['total_value'],
            installments : $data['installments'],
            transaction_id: $data['transaction_id'],
            payment_link: $data['payment_link'] ?? null,
            qr_code: $data['qr_code'] ?? null,
            customer_credit_card_id: $data['customer_credit_card_id'] ?? null,
            order_id: $data['order_id'],
            form_request: $data['form_request'],
            api_request: $data['api_request'] ?? null,
            api_response : $data['api_response'] ?? null,
            credit_card: CustomerCreditCardData::fromArray($data['credit_card']) ?? [],
            credit_card_holder: [],

        );
    }
}
