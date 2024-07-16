<?php

namespace Tests\Unit\PaymentServiceData;

use PHPUnit\Framework\TestCase;
use App\DataObjects\PaymentServiceData\CustomerCreditcardRequestData;

class CustomerCreditcardRequestDataTest extends TestCase
{
    public function testFromArray()
    {
        $data = [
            'holderName' => 'John Doe',
            'number' => '4111111111111111',
            'expiryDate' => '12/25',
            'cvv' => '123'
        ];

        $dto = CustomerCreditcardRequestData::fromArray($data);

        $this->assertEquals('John Doe', $dto->holderName);
        $this->assertEquals('4111111111111111', $dto->number);
        $this->assertEquals('12', $dto->expiryMonth);
        $this->assertEquals('25', $dto->expiryYear);
        $this->assertEquals('123', $dto->ccv);
    }
}
