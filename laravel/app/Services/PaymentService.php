<?php

namespace App\Services;

use App\DataObjects\{CustomerData, CustomerAddressData, PaymentData};
use App\DataObjects\PaymentServiceData\{PaymentRequestData, CustomerRequestData};
use App\Http\Requests\CheckoutDataRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\DataObjects\MockData\MockData;
use App\Http\Controllers\{CustomerController, CustomerAddressController};
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentService
{

    private string $version;
    private string $mode;
    private string $baseUrl;
    private array $headers;
    private JsonResource  $customer;
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

    public function createCustomer(CustomerData $data): mixed
    {
        $request = CustomerRequestData::fromArray($data->toArray());
        $response = $this->client->post('customers', $request->toArray());
        if (!$response->successful()) {
            report($response->body(), $response->status());
            return $response->body();
        }
        $this->storeCustomerInfo($response->json());
        return $response->json();
    }

    public function getCustomer(string $id): mixed
    {
        $response = $this->client->get("customers/{$id}");
        if (!$response->successful()) {
            report($response->body(), $response->status());
            return $response->body();
        }
        $this->storeCustomerInfo($response->json());
        return $response->json();
    }


    private function storeCustomerInfo(array $response): void
    {
        $customerData = CustomerData::fromResponse($response);
        $this->customer = app(CustomerController::class)->store($customerData);
        $response = array_merge($response, ['customer_id' => $this->customer->id]);
        $customerAddressData = CustomerAddressData::fromResponse($response);
        app(CustomerAddressController::class)->store($customerAddressData);
    }


    public function processTransaction(CheckoutDataRequest $data): array
    {

        $customer = $this->createCustomer(CustomerData::fromArray($data->all()['info']));
        // $customer = $this->getCustomer('cus_000006097772');
        $data = array_merge($data->toArray(), ['customerApiId' => $customer['id']]);

        $request = PaymentRequestData::fromArray($data);
        if ($request->billingType === 'CREDIT_CARD') {
            if($request->creditCard->number === '5184019740373151')
            {
                $response = (array) MockData::creditcardRefusedResponse();
            }else{
                $response = (array) MockData::creditcardConfirmedResponse();
            };

        } else {
            $apiResponse = $this->client->post('payments', $request->toArray());
            $response = $apiResponse->json();
        }


        if ($request->billingType === 'PIX') {
            $pixResponse = $this->getPixQrCode($response["id"]);
            $response = array_merge($response, ["qr_code" => $pixResponse]);
        }
        $success = $this->validateResponse($response);

        return [
            'response' => $response,
            'customer_id' =>  $this->customer->id,
            'request' => $request,
            'success' => $success['success'],
            'redirect' => $success['redirect'] ?? null,
            'error' => $success['error'] ?? null,
        ];
    }


    private function getPixQrCode(string $id): array
    {
        $response = $this->client->get("payments/$id/pixQrCode", ["type" => "EVP"]);

        if (!$response->json('success')) {
            report($response->body(), $response->status());
            return new JsonResponse(['success' => false, 'error' => $response->body()], $response->status());
        }

        return [
            'encodedImage' => $response->json()['encodedImage'],
            'payload' => $response->json()['payload'],
            'expirationDate' => $response->json()['payload'],
        ];
    }


    private function validateResponse(array $response): array
    {

        if (isset($response['errors']) && is_array($response['errors']) && count($response['errors']) > 0) {

            return [
                "success" => false,
                "error" => "Erro ao processar a Transação, Verifique os Dados inseridos ou entre em Contato com o nosso Suporte."
            ];
        }

        return [
            'success' => true,
            'redirect' => route('checkout.thankspage', ["transaction_id" => $response['id']])
        ];
    }
}
