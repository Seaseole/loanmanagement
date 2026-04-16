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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('id_number')->unique(); // Omang for citizens
            $table->string('phone_number')->unique(); // E.164 format: +267...
            $table->string('email')->unique()->nullable();
            $table->enum('district', [
                'Central', 'Chobe', 'Ghanzi', 'Kgalagadi', 'Kgatleng', 
                'Kweneng', 'North-East', 'North-West', 'South-East', 'Southern'
            ]);
            $table->string('city_town');
            $table->text('physical_address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
