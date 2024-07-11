<?php

namespace App\Services;

use App\DataObjects\CustomerData;
use App\DataObjects\PaymentData;
use App\DataObjects\PaymentServiceData\{PaymentRequestData, CustomerRequestData};
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function createCustomer(CustomerData $data): JsonResponse
    {
        $request = CustomerRequestData::fromArray($data->toArray());
        $response = $this->client->post('customers', $request->toArray());
        if (!$response->successful()) {
            report($response->body(), $response->status());
            return new JsonResponse($response->body(), $response->status());
        }
        return new JsonResponse($response->json(), 200);
    }


    public function processTransaction(PaymentData $data): JsonResource
    {
        $request = PaymentRequestData::fromArray($data->toArray());
        $response = $this->client->post('payments', $request->toArray());
        $responseData = $response->json();

        if ($request->billingType === 'PIX') {
            $pixResponse = $this->getPixQrCode($responseData["id"]);
            $responseData = array_merge($responseData, ["qrCode" => $pixResponse]);
        }

        return new JsonResource([
            'response' => $responseData,
            'request' => $data->toArray()
        ]);
    }

    public function getPixQrCode(string $id): JsonResponse
    {
        $response = $this->client->get("payments/$id/pixQrCode", [
            "type" => "EVP"
        ]);

        if (!$response->json('success')) {
            report($response->body(), $response->status());
            return new JsonResponse($response->body(), $response->status());
        }
        return new JsonResponse($response->json(), 200);
    }
}
