<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_checkout_with_credit_card(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'payment_method' => 'credit_card',
            'amount' => 100.00,
            'card_number' => '4111111111111111',
            'expiration_date' => '12/25',
            'cvv' => '123'
        ];

        $response = $this->postJson('/api/checkout', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'pending',
                'amount' => 100.00
            ]);
    }

    public function test_can_checkout_with_boleto(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'payment_method' => 'boleto',
            'amount' => 100.00
        ];

        $response = $this->postJson('/api/checkout', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'pending',
                'amount' => 100.00
            ]);
    }

    public function test_can_checkout_with_pix(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'payment_method' => 'pix',
            'amount' => 100.00
        ];

        $response = $this->postJson('/api/checkout', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'pending',
                'amount' => 100.00
            ]);
    }

    public function test_can_view_thank_you_page(): void
    {
        $order = Order::factory()->create();

        $response = $this->getJson('/api/checkout/thank-you/' . $order->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $order->id,
                'status' => $order->status,
                'amount' => $order->amount
            ]);
    }
}
