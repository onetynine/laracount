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
        Schema::create('debit_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('customer_id');
            $table->foreignId('invoice_id');
            $table->decimal('amount', 8, 2);
            $table->text('description');
            $table->enum('status', ["pending",""]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debit_notes');
    }
};
