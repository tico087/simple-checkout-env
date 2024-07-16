<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    // use RefreshDatabase;

    // public function test_can_list_customers(): void
    // {
    //     Customer::factory()->count(3)->create();

    //     $response = $this->getJson('/api/customers');

    //     $response->assertStatus(200)
    //         ->assertJsonCount(3);
    // }

    // public function test_can_create_customer(): void
    // {
    //     $data = [
    //         'name' => 'John Doe',
    //         'email' => 'john@example.com',
    //         'phone' => '1234567890'
    //     ];

    //     $response = $this->postJson('/api/customers', $data);

    //     $response->assertStatus(201)
    //         ->assertJson([
    //             'name' => 'John Doe',
    //             'email' => 'john@example.com',
    //             'phone' => '1234567890'
    //         ]);
    // }

    // public function test_can_show_customer(): void
    // {
    //     $customer = Customer::factory()->create();

    //     $response = $this->getJson('/api/customers/' . $customer->id);

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'id' => $customer->id,
    //             'name' => $customer->name,
    //             'email' => $customer->email,
    //             'phone' => $customer->phone
    //         ]);
    // }

    // public function test_can_update_customer(): void
    // {
    //     $customer = Customer::factory()->create();

    //     $data = [
    //         'name' => 'Jane Doe',
    //         'email' => 'jane@example.com',
    //         'phone' => '0987654321'
    //     ];

    //     $response = $this->putJson('/api/customers/' . $customer->id, $data);

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'id' => $customer->id,
    //             'name' => 'Jane Doe',
    //             'email' => 'jane@example.com',
    //             'phone' => '0987654321'
    //         ]);
    // }

    // public function test_can_delete_customer(): void
    // {
    //     $customer = Customer::factory()->create();

    //     $response = $this->deleteJson('/api/customers/' . $customer->id);

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'id' => $customer->id,
    //             'name' => $customer->name,
    //             'email' => $customer->email,
    //             'phone' => $customer->phone
    //         ]);
    // }
}

