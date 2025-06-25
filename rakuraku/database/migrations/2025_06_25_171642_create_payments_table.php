<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('ride_id')->nullable()->constrained('rides', 'ride_id');
            $table->string('stripe_payment_intent_id')->nullable(); // Lưu ID thanh toán từ Stripe
            $table->string('stripe_customer_id')->nullable();       // Lưu ID khách hàng từ Stripe
            $table->enum('method', ['card', 'cash', 'wallet'])->default('card');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['paid', 'unpaid'])->default('paid');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
