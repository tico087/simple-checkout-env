<?php

namespace App\DataObjects;

use App\DataObjects\{CustomerCreditCardData};
use Spatie\LaravelData\Data;


class CustomerData extends Data
{
    public function __construct(
        public string $name,
        public ?string $email,
        public ?string $mobile_phone,
        public ?string $phone,
        public string $doc,
        // public ?CustomerCreditCardData $creditcard,
    ) {
    }

    public static function fromArray(array $data): static
    {
        // dd($data);
        return new static(
            name: $data['name'],
            email: $data['email'] ?? null,
            mobile_phone: $data['mobile_phone'] ?? null,
            phone: $data['phone'] ?? null,
            doc: $data['doc'],
            // creditcard: CustomerCreditCardData::fromArray($data['creditcard']) ?? []
        );
    }
}
