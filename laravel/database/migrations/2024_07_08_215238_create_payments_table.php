<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method');
            $table->decimal('amount', 10, 2);
            $table->string('status');
            // $table->timestamp('due_date')->nullable();
            $table->integer('installments')->default(1);
            $table->string('transaction_id');
            $table->string('bankslip_url')->nullable();
            $table->json('qr_code')->nullable();
            $table->unsignedBigInteger('customer_credit_card_id')->nullable();
            $table->foreign('customer_credit_card_id')->references('id')->on('customer_credit_cards')->onDelete('set null');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->json('form_request');
            $table->json('api_request')->nullable();
            $table->json('api_response')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};

