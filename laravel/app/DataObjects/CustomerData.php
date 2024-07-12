<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class CustomerData extends Data
{
    public function __construct(
        public string $name,
        public ?string $email,
        public ?string $mobile_phone,
        public ?string $phone,
        public string $doc_number,
        public ?string $api_id,
    ) {
    }

    public static function fromArray(array $data): static
    {

        return new static(
            name: self::getFullname($data),
            email: $data['email'] ?? null,
            mobile_phone: $data['mobile_phone'] ?? null,
            phone: $data['phone'] ?? null,
            doc_number: $data['docNumber'],
            api_id: $data['api_id'] ?? null,
        );
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            name: $data['name'],
            email: $data['email'] ?? null,
            mobile_phone: $data['mobilePhone'] ?? null,
            phone: $data['phone'] ?? null,
            doc_number: $data['cpfCnpj'],
            api_id: $data['id'] ?? null,
        );
    }

    private static function getFullname(array $data): string {

        return "{$data['firstName']} {$data['lastName']}";
    }



}
