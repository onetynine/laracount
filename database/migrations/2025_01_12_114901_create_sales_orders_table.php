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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('company_id');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->unsignedInteger('term_id')->nullable();
            $table->json('product_ids')->nullable();
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->enum('discount_type', ["flat", "percentage"])->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('note')->nullable();
            $table->enum('status', ["pending", "approved", "rejected", "paid", "cancelled"])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
