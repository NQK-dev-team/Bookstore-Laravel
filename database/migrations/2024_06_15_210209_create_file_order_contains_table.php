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
        Schema::create('file_order_contains', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('order_id', 16)->nullable(false);
            $table->string('book_id', 20)->nullable(false);
            $table->timestamps();

            // Real primary key
            $table->unique(['order_id', 'book_id']);

            // Foreign keys
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_order_contains');
    }
};
