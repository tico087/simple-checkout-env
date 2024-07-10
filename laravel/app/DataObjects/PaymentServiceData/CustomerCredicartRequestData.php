<?php

namespace App\DataObjects\PaymentServiceData;

use Spatie\LaravelData\Data;

class CustomerCredicardRequestData extends Data
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
            holderName: $data["holder_name"],
            number: $data["number"],
            expiryMonth: $data["expiry_month"],
            expiryYear: $data["expiry_year"],
            ccv: $data["ccv"],

        );
    }
}
