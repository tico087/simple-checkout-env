<?php

namespace App\DataObjects\PaymentServiceData;

use Spatie\LaravelData\Data;

class CustomerCreditcardRequestData extends Data
{
    public function __construct(
        public ?string $holderName,
        public ?string $number,
        public ?string $expiryMonth,
        public ?string $expiryYear,
        public ?string $ccv,

    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            holderName: $data["holder_name"] ?? null,
            number: $data["number"] ?? null,
            expiryMonth: $data["expiry_month"] ?? null,
            expiryYear: $data["expiry_year"] ?? null,
            ccv: $data["ccv"] ?? null,

        );
    }
}
