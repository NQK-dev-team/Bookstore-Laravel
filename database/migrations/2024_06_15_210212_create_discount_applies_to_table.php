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
        Schema::create('discount_applies_to', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('order_id',20)->nullable(false);
            $table->string('discount_id',20)->nullable(false);
            $table->timestamps();

            // Real primary key
            $table->unique(['order_id', 'discount_id']);

            // Foreign keys
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_applies_to');
    }
};
