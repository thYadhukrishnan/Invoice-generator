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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('InvoiceCode');
            $table->integer('CustomerID');
            $table->string('Notes');
            $table->string('Address');
            $table->string('Amount');
            $table->string('Discount');
            $table->tinyInteger('EnableVat');
            $table->string('TotalAmount');
            $table->string('TotalVat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
