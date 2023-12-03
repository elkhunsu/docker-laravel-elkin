<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buy_transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->foreignId('user_id')->constrained('users')->references('user_id');
            $table->foreignId('currency_id')->constrained('currencies')->references('currency_id');
            $table->decimal('amount', 10, 2);
            $table->decimal('total_amount', 15, 2);
            $table->timestamp('timestamp');
            $table->string('notification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_transactions');
    }
};
