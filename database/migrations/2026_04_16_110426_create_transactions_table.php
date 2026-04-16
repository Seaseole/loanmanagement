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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('restrict');
            $table->foreignId('repayment_schedule_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['debit', 'credit']); // debit: leaving customer, credit: received/refunded
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', ['RealPay Debit Order', 'DPO Card/EFT', 'Bank Transfer', 'Mobile Money', 'Cash']);
            $table->string('reference')->unique();
            $table->json('gateway_response')->nullable(); // Encrypted in model
            $table->timestamps();

            $table->index(['loan_id', 'type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
