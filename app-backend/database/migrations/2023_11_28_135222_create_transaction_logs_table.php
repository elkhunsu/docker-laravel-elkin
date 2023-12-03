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
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->foreignId('transaction_id')->constrained('buy_transactions')->onDelete('cascade')->references('transaction_id');
            $table->foreignId('currency_id')->constrained('currencies')->references('currency_id');
            $table->decimal('exchange_rate_used', 10, 4);
            $table->string('type_transaction')->nullable();
            $table->timestamp('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_logs');
    }
};
