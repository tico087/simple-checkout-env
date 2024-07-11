<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\DataObjects\CustomerData;
use Illuminate\Support\Facades\Http;
use App\Services\PaymentService;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\LaravelData\Attributes\Validation\Lowercase;

class CheckoutControllerTest extends TestCase
{

    public function create_customer_payload(): array
    {
        $user = User::factory()->definition();
        $data = [
            "name" => $user['name'],
            "email" => $user['email'],
            "doc" => '24971563792',
            "phone" => "4738010919",
            "mobilePhone" => "4799376637",
            "zipcode" => "01310-000",
            "address" => "Av. Paulista",
            "number" => "150",
            "complement" => "Sala 201",
            "province" => "Centro",
            "externalReference" => "12987382",
            "notificationDisabled" => false,
            "additionalEmails" => "john.doe@asaas.com,john.doe.silva@asaas.com.br",
            "municipalInscription" => "46683695908",
            "stateInscription" => "646681195275",
            "observations" => "ótimo pagador, nenhum problema até o momento"
        ];

        return [
            'response' => app(PaymentService::class)->createCustomer(CustomerData::fromArray($data)),
            'user' => $user
        ];
    }

    public function create_payment_payload($method): array
    {
        // $customer = $this->create_customer_payload();
        // dd($customer);

        $data = [
            "customer_api_id" => 'cus_000006096246',//$customer['response']['id'],
            "payment_method" => $method,
            "due_date" => "2024-10-30",
            "amount" => 100,
            "description" => "Pedido 056984",
            "external_reference" => "056984",
            "total_value" => 100
        ];

        if ($method === "credit_card") {
            $creditcard = [
                "credit_card" => [
                    "holder_name" => "john doe",
                    "number" => "5162306219378829",
                    "expiry_month" => "05",
                    "expiry_year" => "2025",
                    "ccv" => "318"
                ],
                "credit_card_holder" => [
                    "name" => "John Doe",
                    "email" => "john.doe@asaas.com.br",
                    "doc_number" => "24971563792",
                    "zipcode" => "89223-005",
                    "number" => "277",
                    "complement" => null,
                    "phone" => "4738010919",
                    "mobile_phone" => "47998781877"
                ],
                "installments" => 2,
                "total_value" => 105
            ];

            $data = array_merge($data, $creditcard);
            // dd($data);
        }
        $formRequest['form_request'] = $data;
        $data = array_merge($data, $formRequest);
        // dd($data);
        return $data;
    }

    public function test_creates_a_customer_in_asaas(): void
    {
        $customer = $this->create_customer_payload();

        $this->assertArrayHasKey('id', $customer['response']);
        $this->assertEquals($customer['user']['name'], $customer['response']['name']);
        $this->assertEquals($customer['user']['email'], $customer['response']['email']);
    }



    public function test_processes_creditcard_payment_successfully()
    {

        $data = $this->create_payment_payload('CREDIT_CARD');
        $response = $this->post(route('checkout.process'), $data);
        $response->assertStatus(200);

        // dd($data);

        // $response->assertJson([
        //     'object' => 'payment',
        //     'id' => 'pay_080225913252',
        //     'customer' => 'cus_G7Dvo4iphUNk',
        //     'status' => 'PENDING',
        //     'description' => 'Pedido 056984',
        //     'invoiceUrl' => 'https://www.asaas.com/i/080225913252',
        //     'bankSlipUrl' => 'https://www.asaas.com/b/pdf/080225913252',
        // ]);
    }

    public function test_processes_bankslip_payment_successfully()
    {

        $data = $this->create_payment_payload('BOLETO');
        $response = $this->post(route('checkout.process'), $data);
        $response->assertStatus(200);

        // dd($data);

        // $response->assertJson([
        //     'object' => 'payment',
        //     'id' => 'pay_080225913252',
        //     'customer' => 'cus_G7Dvo4iphUNk',
        //     'status' => 'PENDING',
        //     'description' => 'Pedido 056984',
        //     'invoiceUrl' => 'https://www.asaas.com/i/080225913252',
        //     'bankSlipUrl' => 'https://www.asaas.com/b/pdf/080225913252',
        // ]);
    }

    public function test_processes_pix_payment_successfully()
    {

        $data = $this->create_payment_payload('PIX');
        $response = $this->post(route('checkout.process'), $data);
        $response->assertStatus(200);

        // dd($data);

        // $response->assertJson([
        //     'object' => 'payment',
        //     'id' => 'pay_080225913252',
        //     'customer' => 'cus_G7Dvo4iphUNk',
        //     'status' => 'PENDING',
        //     'description' => 'Pedido 056984',
        //     'invoiceUrl' => 'https://www.asaas.com/i/080225913252',
        //     'bankSlipUrl' => 'https://www.asaas.com/b/pdf/080225913252',
        // ]);
    }





    // public function test_returns_error_for_invalid_customer_400()
    // {

    //     Http::fake([
    //         'https://sandbox.asaas.com/api/v3/payments' => Http::response([
    //             'errors' => [
    //                 [
    //                     'code' => 'invalid_customer',
    //                     'description' => 'Customer inválido ou não informado.'
    //                 ]
    //             ]
    //         ], 400)
    //     ]);


    //     $data = [
    //         'name' => 'Cliente Teste',
    //         'email' => 'cliente@teste.com',
    //         'phone' => '1234567890',
    //         'payment_method' => 'boleto',
    //         'address_street' => 'Rua Teste',
    //         'address_number' => '123',
    //         'address_complement' => 'Apt 456',
    //         'address_neighborhood' => 'Bairro Teste',
    //         'address_city' => 'Cidade Teste',
    //         'address_state' => 'Estado Teste',
    //         'address_postal_code' => '12345678',
    //     ];


    //     $response = $this->postJson(route('checkout.process'), $data);


    //     $response->assertStatus(400);


    //     $response->assertJson([
    //         'errors' => [
    //             [
    //                 'code' => 'invalid_customer',
    //                 'description' => 'Customer inválido ou não informado.'
    //             ]
    //         ]
    //     ]);
    // }


    // public function test_returns_error_for_invalid_customer_401()
    // {

    //     Http::fake([
    //         'https://sandbox.asaas.com/api/v3/payments' => Http::response([
    //             'errors' => [
    //                 [
    //                     'code' => 'invalid_customer',
    //                     'description' => 'Customer inválido ou não informado.'
    //                 ]
    //             ]
    //         ], 401)
    //     ]);


    //     $data = [
    //         'name' => 'Cliente Teste',
    //         'email' => 'cliente@teste.com',
    //         'phone' => '1234567890',
    //         'payment_method' => 'boleto',
    //         'address_street' => 'Rua Teste',
    //         'address_number' => '123',
    //         'address_complement' => 'Apt 456',
    //         'address_neighborhood' => 'Bairro Teste',
    //         'address_city' => 'Cidade Teste',
    //         'address_state' => 'Estado Teste',
    //         'address_postal_code' => '12345678',
    //     ];


    //     $response = $this->postJson(route('checkout.process'), $data);

    //     $response->assertStatus(401);


    //     $response->assertJson([
    //         'errors' => [
    //             [
    //                 'code' => 'invalid_customer',
    //                 'description' => 'Customer inválido ou não informado.'
    //             ]
    //         ]
    //     ]);
    // }


    // public function test_can_view_thank_you_page(): void
    // {
    //     $order = Order::factory()->create();

    //     $response = $this->getJson('/checkout/thank-you/' . $order->id);

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'id' => $order->id,
    //             'status' => $order->status,
    //             'amount' => $order->amount
    //         ]);
    // }

    // public function test_creates_customer_successfully()
    // {
    //     Http::fake([
    //         'https://sandbox.asaas.com/api/v3/customers' => Http::response([
    //             'object' => 'customer',
    //             'id' => 'cus_13bFHumeyglN',
    //             'dateCreated' => '08/03/2017',
    //             'name' => 'John Doe',
    //             'email' => 'john.doe@asaas.com.br',
    //             'phone' => '4738010919',
    //             'mobilePhone' => '4799376637',
    //             'address' => 'Av. Paulista',
    //             'addressNumber' => '150',
    //             'complement' => 'Sala 201',
    //             'province' => 'Centro',
    //             'postalCode' => '01310000',
    //             'cpfCnpj' => '24971563792',
    //             'personType' => 'FISICA',
    //             'deleted' => false,
    //             'additionalEmails' => 'john.doe@asaas.com,john.doe.silva@asaas.com.br',
    //             'externalReference' => '12987382',
    //             'notificationDisabled' => false,
    //             'city' => 15873,
    //             'cityName' => 'São Paulo',
    //             'state' => 'SP',
    //             'country' => 'Brasil',
    //             'observations' => 'ótimo pagador, nenhum problema até o momento',
    //         ], 200)
    //     ]);


    //     $data = [
    //         'name' => 'John Doe',
    //         'email' => 'john.doe@asaas.com.br',
    //         'phone' => '4738010919',
    //         'mobilePhone' => '4799376637',
    //         'cpfCnpj' => '24971563792',
    //         'postalCode' => '01310-000',
    //         'address' => 'Av. Paulista',
    //         'addressNumber' => '150',
    //         'complement' => 'Sala 201',
    //         'province' => 'Centro',
    //         'externalReference' => '12987382',
    //         'notificationDisabled' => false,
    //         'additionalEmails' => 'john.doe@asaas.com,john.doe.silva@asaas.com.br',
    //         'municipalInscription' => '46683695908',
    //         'stateInscription' => '646681195275',
    //         'observations' => 'ótimo pagador, nenhum problema até o momento',
    //     ];


    //     $response = $this->postJson(route('customers.store'), $data);
    //     $response->assertStatus(200);
    //     $response->assertJson([
    //         'object' => 'customer',
    //         'id' => 'cus_13bFHumeyglN',
    //         'name' => 'John Doe',
    //         'email' => 'john.doe@asaas.com.br',
    //         'phone' => '4738010919',
    //         'mobilePhone' => '4799376637',
    //         'address' => 'Av. Paulista',
    //         'addressNumber' => '150',
    //         'complement' => 'Sala 201',
    //         'province' => 'Centro',
    //         'postalCode' => '01310000',
    //         'cpfCnpj' => '24971563792',
    //         'personType' => 'FISICA',
    //         'deleted' => false,
    //         'additionalEmails' => 'john.doe@asaas.com,john.doe.silva@asaas.com.br',
    //         'externalReference' => '12987382',
    //         'notificationDisabled' => false,
    //         'city' => 15873,
    //         'cityName' => 'São Paulo',
    //         'state' => 'SP',
    //         'country' => 'Brasil',
    //         'observations' => 'ótimo pagador, nenhum problema até o momento',
    //     ]);
    // }

    // public function test_returns_error_for_invalid_cpf_cnpj_400()
    // {

    //     Http::fake([
    //         'https://sandbox.asaas.com/api/v3/customers' => Http::response([
    //             'errors' => [
    //                 [
    //                     'code' => 'invalid_cpfCnpj',
    //                     'description' => 'O CPF ou CNPJ informado é inválido.'
    //                 ]
    //             ]
    //         ], 400)
    //     ]);

    //     $data = [
    //         'name' => 'John Doe',
    //         'email' => 'john.doe@asaas.com.br',
    //         'phone' => '4738010919',
    //         'mobilePhone' => '4799376637',
    //         'cpfCnpj' => 'invalid_cpf_cnpj',
    //         'postalCode' => '01310-000',
    //         'address' => 'Av. Paulista',
    //         'addressNumber' => '150',
    //         'complement' => 'Sala 201',
    //         'province' => 'Centro',
    //         'externalReference' => '12987382',
    //         'notificationDisabled' => false,
    //         'additionalEmails' => 'john.doe@asaas.com,john.doe.silva@asaas.com.br',
    //         'municipalInscription' => '46683695908',
    //         'stateInscription' => '646681195275',
    //         'observations' => 'ótimo pagador, nenhum problema até o momento',
    //     ];

    //     $response = $this->postJson(route('customers.store'), $data);
    //     $response->assertStatus(400);
    //     $response->assertJson([
    //         'errors' => [
    //             [
    //                 'code' => 'invalid_cpfCnpj',
    //                 'description' => 'O CPF ou CNPJ informado é inválido.'
    //             ]
    //         ]
    //     ]);
    // }
}
