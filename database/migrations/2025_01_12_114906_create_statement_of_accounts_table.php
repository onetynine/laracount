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
        Schema::create('statement_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('customer_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_due', 8, 2);
            $table->string('currency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statement_of_accounts');
    }
};
