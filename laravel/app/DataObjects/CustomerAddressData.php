<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class CustomerAddressData extends Data
{
    public function __construct(
        public int $customer_id,
        public ?string $address,
        public ?string $city,
        public ?string $neighborhood,
        public ?string $state,
        public string $zipcode,
        public ?string $number,
        public ?string $complement
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            customer_id: $data['customer_id'],
            address: $data['address'] ?? null,
            neighborhood: $data['neighborhood'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
            zipcode: $data['zipcode'],
            number: $data['number'] ?? null,
            complement: $data['complement'] ?? null,
        );
    }


    public static function fromResponse(array $data): static
    {
        return new static(
            customer_id: $data['customer_id'],
            address: $data['address'] ?? null,
            neighborhood: $data['province'] ?? null,
            city: $data['cityName'] ?? null,
            state: $data['state'] ?? null,
            zipcode: $data['postalCode'],
            number: $data['addressNumber'] ?? null,
            complement: $data['complement'] ?? null,
        );
    }
}
