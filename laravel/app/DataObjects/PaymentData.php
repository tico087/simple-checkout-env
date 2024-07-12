<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;
use App\DataObjects\{CustomerCreditCardData};
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

class PaymentData extends Data
{
    public function __construct(

        public string $payment_method,
        public float $amount,
        public string $status,
        public ?string $description,
        public string $transaction_id,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public ?Carbon $due_date,
        public ?int $installments,
        public ?string $bankslip_url,
        public ?string $qr_code,
        public ?int $customer_credit_card_id,
        public int $order_id,
        public ?array $form_request,
        public ?array $api_request,
        public ?array $api_response,




    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            payment_method : $data['payment_method'],
            amount: $data['amount'],
            status: $data['status'],
            description: $data['description'] ?? null,
            transaction_id: $data['transaction_id'],
            due_date: isset($data['due_date']) ? Carbon::createFromFormat('Y-m-d', $data['due_date']) : null,
            installments : $data['installments'] ?? null,
            bankslip_url: $data['payment_link'] ?? null,
            qr_code: $data['qr_code'] ?? null,
            customer_credit_card_id: $data['customer_credit_card_id'] ?? null,
            order_id: $data['order_id'] ?? null,
            form_request: $data['form_request'] ?? null,
            api_request: $data['api_request'] ?? null,
            api_response : $data['api_response'] ?? null,


        );
    }

    public static function fromRespose(array $data): static
    {
        return new static(
            payment_method : $data['billingType'],
            amount: $data['value'],
            status: $data['status'],
            description: $data['description'] ?? null,
            transaction_id: $data['id'],
            due_date: isset($data['dueDate']) ? Carbon::createFromFormat('Y-m-d', $data['dueDate']) : null,
            installments : is_int($data['installmentNumber'])?: null,
            bankslip_url: $data['payment_link'] ?? null,
            qr_code: $data['qr_code'] ?? null,
            customer_credit_card_id: $data['customer_credit_card_id'] ?? null,
            order_id: $data['order_id'] ?? null,
            form_request: $data['form_request'] ?? null,
            api_request: $data['api_request'] ?? null,
            api_response : $data['api_response'] ?? null,

        );
    }


}
