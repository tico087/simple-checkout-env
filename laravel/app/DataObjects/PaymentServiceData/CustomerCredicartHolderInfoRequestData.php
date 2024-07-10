<?php

namespace App\DataObjects\PaymentServiceData;

use Spatie\LaravelData\Data;

class CustomerCredicartHolderInfoRequestData extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $email,
        public ?string $cpfCnpj,
        public ?string $postalCode,
        public ?string $addressNumber,
        public ?string $phone,
        public ?string $mobilePhone,

    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data["name"],
            email: $data["email"] ?? null,
            cpfCnpj: $data["doc_number"],
            postalCode: $data["zipcode"] ?? null,
            addressNumber: $data["number"] ?? null,
            phone: $data["phone"] ?? null,
            mobilePhone: $data["mobile_phone"] ?? null,
        );
    }
}
