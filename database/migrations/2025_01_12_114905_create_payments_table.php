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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('customer_id');
            $table->unsignedInteger('invoice_id');
            $table->decimal('amount', 8, 2);
            $table->enum('payment_method', ["bank_transfer",""]);
            $table->string('transaction_reference');
            $table->date('payment_date');
            $table->enum('status', ["completed",""]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
