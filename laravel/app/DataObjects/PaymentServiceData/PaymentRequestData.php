<?php

namespace App\DataObjects\PaymentServiceData;

use Spatie\LaravelData\Data;
use App\DataObjects\PaymentServiceData\{CustomerCreditcardRequestData, CustomerCreditcardHolderInfoRequestData};


class PaymentRequestData extends Data
{
    public function __construct(
        public string $customer,
        public string $billingType,
        public string $dueDate,
        public float $value,
        public ?string $description,
        public ?string $externalReference,
        public ?int $installmentCount = 1,
        public ?float $totalValue,
        public ?CustomerCreditcardRequestData $creditCard,
        public ?CustomerCreditcardHolderInfoRequestData $creditCardHolderInfo,


    ) {
    }

    public static function fromArray(array $data): static
    {

        return new static(
            customer: $data['customer_api_id'],
            billingType: $data['payment_method'],
            dueDate: $data['due_date'],
            value: $data['amount'],
            description: $data['description'] ?? null,
            externalReference: $data['external_reference'] ?? null,
            installmentCount: $data['installments'] ?? 1,
            totalValue: $data['total_value'] ?? null,
            creditCard: isset($data['credit_card']) ? CustomerCreditcardRequestData::fromArray($data['credit_card']) : null,
            creditCardHolderInfo: isset($data['credit_card_holder']) ? CustomerCreditcardHolderInfoRequestData::fromArray($data['credit_card_holder']) : null

        );
    }
}
