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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('industry')->nullable();
            $table->string('code')->unique()->nullable();
            $table->json('business_address');
            $table->json('delivery_address');
            $table->string('registration_number')->unique();
            $table->string('contact_number');
            $table->enum('status', ["inactive", "active", "suspended"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
