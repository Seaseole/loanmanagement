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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->morphs('documentable'); // Link to Customer or Loan
            $table->string('name');
            $table->string('file_path');
            $table->string('mime_type');
            $table->integer('file_size');
            $table->string('type'); // e.g., ID_COPY, PROOF_OF_RESIDENCE, LOAN_AGREEMENT
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
