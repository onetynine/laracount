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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->decimal('price', 8, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->text('description')->nullable();
            $table->enum('status', ["active", "inactive", "suspended"])->default('active');
            $table->foreignId('company_id');
            $table->foreignId('tax_id')->nullable();
            $table->foreignId('supplier_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
