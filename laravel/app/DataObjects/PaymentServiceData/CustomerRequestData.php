<?php

namespace App\DataObjects\PaymentServiceData;

use Spatie\LaravelData\Data;

class CustomerRequestData extends Data
{
    public function __construct(
        public string $name,
        public ?string $email,
        public ?string $phone,
        public ?string $mobilePhone,
        public string $cpfCnpj,
        public ?string $postalCode,
        public ?string $address,
        public ?string $addressNumber,
        public ?string $complement,
        public ?string $province,
        public ?string $externalReference,
        public ?bool $notificationDisabled,
        public ?string $additionalEmails,
        public ?string $municipalInscription,
        public ?string $stateInscription,
        public ?string $observations
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data["name"],
            email: $data["email"] ?? null,
            phone: $data["phone"] ?? null,
            mobilePhone: $data["mobilePhone"] ?? null,
            cpfCnpj: $data["doc"],
            postalCode: $data["zipcode"] ?? null,
            address: $data["address"] ?? null,
            addressNumber: $data["number"] ?? null,
            complement: $data["complement"] ?? null,
            province: $data["neighborhood"] ?? null,
            externalReference: $data["externalReference"] ?? null,
            notificationDisabled: $data["notificationDisabled"] ?? null,
            additionalEmails: $data["additionalEmails"] ?? null,
            municipalInscription: $data["municipalInscription"] ?? null,
            stateInscription: $data["stateInscription"] ?? null,
            observations: $data["observations"] ?? null
        );
    }
}
