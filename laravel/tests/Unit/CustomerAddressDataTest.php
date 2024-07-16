<?php

namespace Tests\Unit\DataObjects;

use PHPUnit\Framework\TestCase;
use App\DataObjects\CustomerAddressData;

class CustomerAddressDataTest extends TestCase
{
    public function testFromArray()
    {
        $data = [
            'customer_id' => 1,
            'address' => 'Street Name',
            'city' => 'City Name',
            'neighborhood' => 'Neighborhood',
            'state' => 'State Name',
            'zipcode' => '12345',
            'number' => '678',
            'complement' => 'Apt 9'
        ];

        $dto = CustomerAddressData::fromArray($data);

        $this->assertEquals(1, $dto->customer_id);
        $this->assertEquals('Street Name', $dto->address);
        $this->assertEquals('City Name', $dto->city);
        $this->assertEquals('Neighborhood', $dto->neighborhood);
        $this->assertEquals('State Name', $dto->state);
        $this->assertEquals('12345', $dto->zipcode);
        $this->assertEquals('678', $dto->number);
        $this->assertEquals('Apt 9', $dto->complement);
    }

    public function testFromResponse()
    {
        $data = [
            'customer_id' => 1,
            'address' => 'Street Name',
            'province' => 'Neighborhood',
            'cityName' => 'City Name',
            'state' => 'State Name',
            'postalCode' => '12345',
            'addressNumber' => '678',
            'complement' => 'Apt 9'
        ];

        $dto = CustomerAddressData::fromResponse($data);

        $this->assertEquals(1, $dto->customer_id);
        $this->assertEquals('Street Name', $dto->address);
        $this->assertEquals('City Name', $dto->city);
        $this->assertEquals('Neighborhood', $dto->neighborhood);
        $this->assertEquals('State Name', $dto->state);
        $this->assertEquals('12345', $dto->zipcode);
        $this->assertEquals('678', $dto->number);
        $this->assertEquals('Apt 9', $dto->complement);
    }
}
