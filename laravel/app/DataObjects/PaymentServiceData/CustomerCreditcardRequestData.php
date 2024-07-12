<?php

namespace App\DataObjects\PaymentServiceData;

use Spatie\LaravelData\Data;

class CustomerCreditcardRequestData extends Data
{
    public function __construct(
        public string $holderName,
        public string $number,
        public string $expiryMonth,
        public string $expiryYear,
        public string $ccv,

    ) {
    }

    public static function fromArray(array $data): static
    {
        $date = self::formatExpiryDate($data['expiryDate']);
        return new static(
            holderName: $data["holderName"],
            number: $data["number"],
            expiryMonth: $date["expiryMonth"],
            expiryYear: $date["expiryYear"],
            ccv: $data["cvv"],

        );
    }

    public static function formatExpiryDate(string $expiryDate): array
    {
        list($expiryMonth, $expiryYear) = explode('/', $expiryDate);

        return [
            'expiryMonth' => $expiryMonth,
            'expiryYear' => $expiryYear
        ];
    }
}
