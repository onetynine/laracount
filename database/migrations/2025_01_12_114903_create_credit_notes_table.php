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
        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('company_id');
            $table->json('product_ids')->nullable();
            $table->foreignId('invoice_id')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->string('note')->nullable();
            $table->unsignedInteger('term_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_notes');
    }
};
