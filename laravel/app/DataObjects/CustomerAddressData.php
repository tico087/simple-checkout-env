<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class CustomerAddressData extends Data
{
    public function __construct(
        public int $customer_id,
        public string $address,
        public string $city,
        public string $neighborhood,
        public string $state,
        public string $zipcode,
        public ?string $number,
        public ?string $complement
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            $data['customer_id'],
            $data['address'],
            $data['neighborhood'],
            $data['city'],
            $data['state'],
            $data['zipcode'],
            $data['number'],
            $data['complement'],
        );
    }
}
