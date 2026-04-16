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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('restrict');
            $table->decimal('principal_amount', 15, 2);
            $table->decimal('interest_rate', 5, 2); // Annual percentage
            $table->integer('term_months');
            $table->enum('loan_status', ['pending', 'approved', 'disbursed', 'active', 'delinquent', 'npa', 'closed'])->default('pending');
            $table->date('application_date');
            $table->date('approval_date')->nullable();
            $table->date('disbursement_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['customer_id', 'loan_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
