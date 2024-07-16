<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\DataObjects\PaymentData;

class PaymentDataTest extends TestCase
{
    public function testFromArray()
    {
        $data = [
            'payment_method' => 'credit_card',
            'amount' => 150.50,
            'status' => 'paid',
            'description' => 'Payment for services',
            'transaction_id' => 'txn_12345',
            'installments' => 3,
            'bankslip_url' => 'https://example.com/bankslip',
            'qr_code' => ['code' => 'qrcode123'],
            'invoice_url' => 'https://example.com/invoice',
            'customer_credit_card_id' => 5,
            'order_id' => 10,
            'form_request' => ['field1' => 'value1'],
            'api_request' => ['field2' => 'value2'],
            'api_response' => ['field3' => 'value3'],
            'customer_id' => 20
        ];

        $paymentData = PaymentData::fromArray($data);

        $this->assertEquals('credit_card', $paymentData->payment_method);
        $this->assertEquals(150.50, $paymentData->amount);
        $this->assertEquals('paid', $paymentData->status);
        $this->assertEquals('Payment for services', $paymentData->description);
        $this->assertEquals('txn_12345', $paymentData->transaction_id);
        $this->assertEquals(3, $paymentData->installments);
        $this->assertEquals('https://example.com/bankslip', $paymentData->bankslip_url);
        $this->assertEquals(['code' => 'qrcode123'], $paymentData->qr_code);
        $this->assertEquals('https://example.com/invoice', $paymentData->invoice_url);
        $this->assertEquals(5, $paymentData->customer_credit_card_id);
        $this->assertEquals(10, $paymentData->order_id);
        $this->assertEquals(['field1' => 'value1'], $paymentData->form_request);
        $this->assertEquals(['field2' => 'value2'], $paymentData->api_request);
        $this->assertEquals(['field3' => 'value3'], $paymentData->api_response);
        $this->assertEquals(20, $paymentData->customer_id);
    }

    public function testFromRespose()
    {
        $data = [
            'response' => [
                'billingType' => 'credit_card',
                'value' => 150.50,
                'status' => 'paid',
                'description' => 'Payment for services',
                'id' => 'txn_12345',
                'installmentNumber' => 3,
                'bankSlipUrl' => 'https://example.com/bankslip',
                'invoiceUrl' => 'https://example.com/invoice',
                'qr_code' => ['code' => 'qrcode123'],
                'customer_credit_card_id' => 5,
                'order_id' => 10
            ],
            'form_request' => ['field1' => 'value1'],
            'request' => ['field2' => 'value2'],
            'customer_id' => 20
        ];

        $paymentData = PaymentData::fromRespose($data);


        $this->assertEquals('credit_card', $paymentData->payment_method);
        $this->assertEquals(150.50, $paymentData->amount);
        $this->assertEquals('paid', $paymentData->status);
        $this->assertEquals('Payment for services', $paymentData->description);
        $this->assertEquals('txn_12345', $paymentData->transaction_id);
        $this->assertEquals(3, $paymentData->installments);
        $this->assertEquals('https://example.com/bankslip', $paymentData->bankslip_url);
        $this->assertEquals(['code' => 'qrcode123'], $paymentData->qr_code);
        $this->assertEquals('https://example.com/invoice', $paymentData->invoice_url);
        $this->assertEquals(5, $paymentData->customer_credit_card_id);
        $this->assertEquals(10, $paymentData->order_id);
        $this->assertEquals(['field1' => 'value1'], $paymentData->form_request);
        $this->assertEquals(['field2' => 'value2'], $paymentData->api_request);
        $this->assertEquals(['code' => 'qrcode123'], $paymentData->api_response['qr_code']);
        $this->assertEquals(20, $paymentData->customer_id);
    }
}
