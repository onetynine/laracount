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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->foreignId('user_id');
            $table->foreignId('customer_id');
            $table->foreignId('company_id');
            $table->json('tax_id')->nullable();
            $table->unsignedInteger('term_id')->nullable();
            $table->json('product_id');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('total', 8, 2);
            $table->string('currency');
            $table->string('note')->nullable();
            $table->enum('status', ["draft",""]);
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
