<?php

namespace App\DataObjects\PaymentServiceData;

use Spatie\LaravelData\Data;
use App\DataObjects\PaymentServiceData\{CustomerCreditcardRequestData, CustomerCreditcardHolderInfoRequestData};
use Illuminate\Support\Carbon;

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
        public ?float $installmentValue,
        public ?float $totalValue,
        public ?CustomerCreditcardRequestData $creditCard,
        public ?CustomerCreditcardHolderInfoRequestData $creditCardHolderInfo,


    ) {
    }

    public static function fromArray(array $data): static
    {

        $value = $data['payment']['total'];
        $installments = $data['payment']['installments'] ?? 1;
        $installmentValue = round($value / $installments, 2);

        return new static(
            customer: $data['customerApiId'],
            billingType: $data['payment']['billingType'],
            dueDate: self::processDueDate(),
            value: $value,
            description: $data['description'] ?? null,
            externalReference: $data['externalReference'] ?? null,
            installmentCount: $installments,
            installmentValue: $installmentValue,
            totalValue: $data['totalValue'] ?? null,
            creditCard: ($data['payment']['billingType'] === 'CREDIT_CARD') ? CustomerCreditcardRequestData::fromArray($data['payment']) : null,
            creditCardHolderInfo: CustomerCreditcardHolderInfoRequestData::fromArray($data)

        );
    }

    private static function processDueDate(): string
    {
        $dueDate = Carbon::now()->addDay();
        return $dueDate->format('Y-m-d');
    }
}
