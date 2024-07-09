<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class CustomerAddressData extends Data
{
    public function __construct(
        public int $customer_id,
        public string $address_line,
        public string $city,
        public string $state,
        public string $postal_code
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['customer_id'],
            $data['address_line'],
            $data['city'],
            $data['state'],
            $data['postal_code']
        );
    }
}
