<?php

namespace App\DataObjects\PaymentServiceData;

use Spatie\LaravelData\Data;
use App\DataObjects\PaymentServiceData\{CustomerCredicardRequestData, CustomerCredicartHolderInfoRequestData};
use FunctionOrMethodName;

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
        public ?CustomerCredicardRequestData $creditCard,
        public ?CustomerCredicartHolderInfoRequestData $creditCardHolderInfo,


    ) {
    }

    public static function fromArray(array $data): static
    {
        dd($data);
        return new static(
            customer: $data['customer_api_id'],
            billingType: $data['payment_method'],
            dueDate: $data['due_date'],
            value: $data['amount'],
            description: $data['description'],
            externalReference: $data['external_reference'],
            installmentCount: $data['installments'],
            totalValue: $data['totalValue'],
            creditCard: CustomerCredicardRequestData::fromArray($data['credit_card']) ?? [],
            creditCardHolderInfo: CustomerCredicartHolderInfoRequestData::fromArray($data['credit_card_holder']) ?? [],

        );
    }
}
