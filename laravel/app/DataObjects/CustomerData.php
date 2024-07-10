<?php

namespace App\DataObjects;

use App\Models\CustomerAddress;
use App\Models\CustomerCreditCard;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

class CustomerData extends Data
{
    public function __construct(
        public string $name,
        public ?string $email,
        public ?string $mobile_phone,
        public ?string $phone,
        public string $doc,

        // #[DataCollectionOf(CustomerAddress::class)]
        // public ?DataCollection $address,

        // #[DataCollectionOf(CustomerCreditCard::class)]
        // public ?DataCollection $creditcard,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            name : $data['name'],
            email: $data['email'] ?? null,
            mobile_phone: $data['mobile_phone'] ?? null,
            phone: $data['phone'] ?? null,
            doc: $data['doc'],
            // address: $data['address'] ?? [],
            // creditcard: $data['creditcard'] ?? []
        );
    }
}

