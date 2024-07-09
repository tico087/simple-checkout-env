<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customer_credit_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('card_number');
            $table->string('expiry_date');
            $table->string('card_holder_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_credit_cards');
    }
};
