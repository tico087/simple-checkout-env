<?php

namespace App\DataObjects\PaymentServiceData;

use Spatie\LaravelData\Data;

class CustomerCreditcardHolderInfoRequestData extends Data

{
    public function __construct(
        public string $name,
        public ?string $email,
        public string $cpfCnpj,
        public ?string $postalCode,
        public ?string $addressNumber,
        public ?string $addressComplement,
        public ?string $phone,
        public ?string $mobilePhone,

    ) {
    }

    public static function fromArray(array $data): static
    {

        return new static(
            name: self::getFullname($data),
            email: $data['info']['email'] ?? null,
            cpfCnpj: $data['info']['docNumber'],
            postalCode: $data['address']['zipcode'] ?? null,
            addressNumber: $data['address']['number'] ?? null,
            phone: $data['info']['phone'] ?? null,
            mobilePhone: $data['info']['mobile_phone'] ?? null,
            addressComplement: $data['address']['complement'] ?? null
        );
    }

    private static function getFullname(array $data): string {

        return "{$data['info']['firstName']} {$data['info']['lastName']}";
    }
}
