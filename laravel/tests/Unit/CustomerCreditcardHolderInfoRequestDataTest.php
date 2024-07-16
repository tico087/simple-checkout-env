<?php

namespace Tests\Unit\PaymentServiceData;

use PHPUnit\Framework\TestCase;
use App\DataObjects\PaymentServiceData\CustomerCreditcardHolderInfoRequestData;

class CustomerCreditcardHolderInfoRequestDataTest extends TestCase
{
    public function testFromArray()
    {
        $data = [
            'info' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'john.doe@example.com',
                'docNumber' => '123456789',
                'phone' => '123456789',
                'mobile_phone' => '987654321'
            ],
            'address' => [
                'zipcode' => '12345',
                'number' => '678',
                'complement' => 'Apt 9'
            ]
        ];

        $dto = CustomerCreditcardHolderInfoRequestData::fromArray($data);

        $this->assertEquals('John Doe', $dto->name);
        $this->assertEquals('john.doe@example.com', $dto->email);
        $this->assertEquals('123456789', $dto->cpfCnpj);
        $this->assertEquals('12345', $dto->postalCode);
        $this->assertEquals('678', $dto->addressNumber);
        $this->assertEquals('123456789', $dto->phone);
        $this->assertEquals('987654321', $dto->mobilePhone);
        $this->assertEquals('Apt 9', $dto->addressComplement);
    }
}
