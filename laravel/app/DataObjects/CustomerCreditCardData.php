<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;
use App\DataObjects\CustomerAddressData;

class CustomerCreditCardData extends Data
{
    public function __construct(
        public int $customer_id,
        public string $card_number,
        public string $expiry_date,
        public string $card_holder_name,
        public string $doc_number,
        public string $cvv,
        public CustomerAddressData $address,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            customer_id: $data['customer_id'],
            card_number: $data['card_number'],
            expiry_date: $data['expiry_date'],
            card_holder_name: $data['card_holder_name'],
            doc_number: $data['doc_number'],
            cvv: $data['cvv'],
            address: CustomerAddressData::fromArray(self::getFullAddress($data))
        );
    }


    private function getFullAddress($data): array
    {
        return [
            $data['customer_id'] ?? null,
            $data['street'] ?? null,
            $data['neighborhood'] ?? null,
            $data['city'] ?? null,
            $data['state'] ?? null,
            $data['zipcode'],
            $data['number'] ?? null,
            $data['complement'] ?? null,
        ];
    }
}
