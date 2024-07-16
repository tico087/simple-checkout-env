<?php

namespace Tests\Unit\PaymentServiceData;

use PHPUnit\Framework\TestCase;
use App\DataObjects\PaymentServiceData\{PaymentRequestData, CustomerCreditcardRequestData, CustomerCreditcardHolderInfoRequestData};

class PaymentRequestDataTest extends TestCase
{
    public function testFromArray()
    {
        $data = [
            'customerApiId' => '123',
            'payment' => [
                'billingType' => 'CREDIT_CARD',
                'total' => 100.0,
                'installments' => 2,
                'cvv' => '123',
                'number' => '4111111111111111',
                'expiryDate' => '12/25',
                'holderName' => 'John Doe',

            ],
            'info' => [
                'docNumber' => '70574958037',
                'firstName' => 'John',
                'lastName' => 'Doe'
            ],
            'description' => 'Payment description',
            'externalReference' => 'ExtRef123'
        ];

        $dto = PaymentRequestData::fromArray($data);

        $this->assertEquals('123', $dto->customer);
        $this->assertEquals('CREDIT_CARD', $dto->billingType);
        $this->assertEquals((new \Illuminate\Support\Carbon)->addDay()->format('Y-m-d'), $dto->dueDate);
        $this->assertEquals(100.0, $dto->value);
        $this->assertEquals('Payment description', $dto->description);
        $this->assertEquals('ExtRef123', $dto->externalReference);
        $this->assertEquals(2, $dto->installmentCount);
        $this->assertEquals(50.0, $dto->installmentValue);
        $this->assertNull($dto->totalValue);
        $this->assertInstanceOf(CustomerCreditcardRequestData::class, $dto->creditCard);
        $this->assertInstanceOf(CustomerCreditcardHolderInfoRequestData::class, $dto->creditCardHolderInfo);
    }
}
