<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class CustomerData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone
    ) {}


    public static function fromArray(array $data): static
    {
        return new static(
            $data['name'],
            $data['email'],
            $data['phone'],

        );
    }
}
