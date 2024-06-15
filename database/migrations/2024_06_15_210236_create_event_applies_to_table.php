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
        Schema::create('event_applies_to', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('event_discount_id', 20)->nullable(false);
            $table->string('book_id', 20)->nullable(false);
            $table->timestamps();

            // Real primary key
            $table->unique(['event_discount_id', 'book_id']);

            // Foreign keys
            $table->foreign('event_discount_id')->references('id')->on('event_discounts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_applies_to');
    }
};
