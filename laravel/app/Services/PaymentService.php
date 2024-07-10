<?php

namespace App\Services;

use App\DataObjects\CustomerData;
use App\DataObjects\PaymentData;
use App\DataObjects\PaymentServiceData\{PaymentRequestData, CustomerRequestData};

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentService
{

    private string $version;
    private string $mode;
    private string $baseUrl;
    private array $headers;
    private PendingRequest $client;

    public function __construct()
    {
        $this->setup();
    }

    private function setup(): void
    {
        $this->version = config('services.payments.asaas.version');
        $this->mode = config('services.payments.asaas.mode');
        $this->baseUrl = "https://{$this->mode}.asaas.com/api/{$this->version}";
        $this->headers =  config('services.payments.asaas.headers');
        $this->makeClient();
    }

    private function makeClient(): void
    {
        $this->client = Http::withHeaders($this->headers)
            ->baseUrl($this->baseUrl);
    }

    public function createApiCustomer(CustomerData $data): JsonResource
    {
        $request = CustomerRequestData::fromArray($data->toArray());
        $response = $this->client->post('customers', $request->toArray());

        if ($response->successful()) {
            return new JsonResource($response->json());
        } else {
            return new JsonResource($response->status(), $response->body());
        }
    }

    // public function getApiCustomer(string $value): mixed
    // {
    //     $response = $this->client->get('customers/' . $value);
    //     return $response->json();
    // }


    public function createPixQrCode(string $apiPaymentId): mixed
    {
        $response = $this->client->get("payments/$apiPaymentId/pixQrCode", [
            "type" => "EVP"
        ]);

        return $response->json();
    }

    // public function getApiPayment(string $id): mixed
    // {
    //     $response = $this->client->get('payments/' . $id);
    //     return $response->json();
    // }

    public function createApiPayment(PaymentData $data): mixed
    {
        $data = PaymentRequestData::fromArray($data->toArray());
        $payload = [
            'externalReference' => $data->id,
            'customer' => $data->customerApiId,
            'billingType' => $data->billingType,
            'value' => $data->total,
            'dueDate' => $paymentData->dueDate,
        ];

        if ($paymentData->billingType === 'CREDIT_CARD') {
            $expiryDate = explode("/", $paymentData->expiryDate);
            $cardData = [
                "creditCard" => [
                    "holderName" => $paymentData->holderName,
                    "number" => str_replace(' ', '', $paymentData->number),
                    "expiryMonth" => $expiryDate[0],
                    "expiryYear" => $expiryDate[1],
                    "ccv" => $paymentData->cvv,
                ],
                "creditCardHolderInfo" => [
                    "name" => $paymentData->holderName,
                    "email" => $paymentData->email,
                    "cpfCnpj" => $paymentData->cpfCnpj,
                    "postalCode" => $paymentData->zipCode,
                    "addressNumber" => $paymentData->addressNumber,
                    "phone" => preg_replace('/[^0-9]/', '', $paymentData->phone)
                ],
                "installmentCount" => $paymentData->installments,
                "installmentValue" => floatval(number_format($paymentData->total / $paymentData->installments, 2, '.', ''))
            ];
            $payload = array_merge($payload, $cardData);
        }

        if ($paymentData->billingType === 'BOLETO') {
            $bankslipData = [
                'dueDate' => $paymentData->dueDate
            ];
            $payload = array_merge($payload, $bankslipData);
        }

        if ($paymentData->billingType === 'PIX') {
            $pixData = [
                'dueDate' => $paymentData->dueDate
            ];
            $payload = array_merge($payload, $pixData);
        }

        $response = $this->client->post('payments', $payload);
        $responseData = $response->json();

        if ($paymentData->billingType === 'PIX') {
            $pixResponse = $this->createPixQrCode(data_get($responseData, "id"));
            $responseData = array_merge($responseData, ["qrCode" => $pixResponse]);
        }

        return [
            'response' => $responseData,
            'request' => $payload
        ];
    }
}
