<?php

namespace App\DataObjects\MockData;

use Spatie\LaravelData\Data;

class MockData extends Data
{
    public function __construct()
    {
    }

    public static function creditcardResponse(): object
    {
        $jsonString = '{
            "object": "payment",
            "id": "pay_080225913252",
            "dateCreated": "2017-03-10",
            "customer": "cus_G7Dvo4iphUNk",
            "paymentLink": "quis",
            "dueDate": "2017-03-15",
            "value": 100,
            "netValue": 94.51,
            "billingType": "CREDIT_CARD",
            "pixTransaction": "anim Lorem",
            "status": "CONFIRMED",
            "description": "Pedido 056984",
            "externalReference": "056984",
            "confirmedDate": "2017-03-15",
            "originalValue": 48075689.13814983,
            "interestValue": 20609002.56946847,
            "originalDueDate": "2017-06-10",
            "paymentDate": "1985-12-26",
            "clientPaymentDate": "2016-07-02",
            "installmentNumber": "ullamco proident consequat nostrud",
            "transactionReceiptUrl": "https://www.asaas.com/comprovantes/9732f4ae3a760ce63e7640e9016d4be1",
            "nossoNumero": "6453",
            "invoiceUrl": "https://www.asaas.com/i/080225913252",
            "bankSlipUrl": "https://www.asaas.com/b/pdf/080225913252",
            "invoiceNumber": "00005101",
            "deleted": false,
            "postalService": false,
            "anticipated": false,
            "anticipable": false,
            "creditCard": {
                "creditCardNumber": "8829",
                "creditCardBrand": "MASTERCARD",
                "creditCardToken": "a75a1d98-c52d-4a6b-a413-71e00b193c99"
            }
        }';

        return (object) json_decode($jsonString, true);
    }

    public static function mockProducts(): array
    {
        return [
            'items' => [
                ['name' => 'Aspirador', 'price' => 237.90, 'id' => 456],
                ['name' => 'Tapete Médio', 'price' => 180.27, 'id' => 841],
            ]
        ];
    }
}
