<?php

namespace Tests\Unit\PaymentServiceData;

use PHPUnit\Framework\TestCase;
use App\DataObjects\PaymentServiceData\CustomerRequestData;

class CustomerRequestDataTest extends TestCase
{
    public function testFromArray()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '123456789',
            'mobilePhone' => '987654321',
            'doc_number' => '123456789',
            'address' => 'Street Name',
            'number' => '678',
            'complement' => 'Apt 9',
            'neighborhood' => 'Neighborhood',
            'externalReference' => 'ExtRef123',
            'notificationDisabled' => true,
            'additionalEmails' => 'additional@example.com',
            'municipalInscription' => 'Municipal123',
            'stateInscription' => 'State123',
            'observations' => 'Some observations'
        ];

        $dto = CustomerRequestData::fromArray($data);

        $this->assertEquals('John Doe', $dto->name);
        $this->assertEquals('john.doe@example.com', $dto->email);
        $this->assertEquals('123456789', $dto->phone);
        $this->assertEquals('987654321', $dto->mobilePhone);
        $this->assertEquals('123456789', $dto->cpfCnpj);
        $this->assertEquals('Street Name', $dto->address);
        $this->assertEquals('678', $dto->addressNumber);
        $this->assertEquals('Apt 9', $dto->complement);
        $this->assertEquals('Neighborhood', $dto->province);
        $this->assertEquals('ExtRef123', $dto->externalReference);
        $this->assertTrue($dto->notificationDisabled);
        $this->assertEquals('additional@example.com', $dto->additionalEmails);
        $this->assertEquals('Municipal123', $dto->municipalInscription);
        $this->assertEquals('State123', $dto->stateInscription);
        $this->assertEquals('Some observations', $dto->observations);
    }
}
