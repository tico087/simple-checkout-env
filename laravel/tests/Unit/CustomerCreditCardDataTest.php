<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\DataObjects\CustomerCreditCardData;

class CustomerCreditCardDataTest extends TestCase
{
    public function testFromArray()
    {
        $data = [
            'customer_id' => 1,
            'token' => '1234',
            'card_holder_name' => 'John Doe',
            'expiry_date' => '11/2025',
            'last_numbers' => '1111'
        ];

        $dto = CustomerCreditCardData::fromArray($data);

        $this->assertEquals(1, $dto->customer_id);
        $this->assertEquals('1234', $dto->token);
        $this->assertEquals('John Doe', $dto->card_holder_name);
        $this->assertEquals('11/2025', $dto->expiry_date);
        $this->assertEquals('1111', $dto->last_numbers);
    }
}
