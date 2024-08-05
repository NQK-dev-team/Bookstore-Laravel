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
        Schema::create('authors', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name', 255)->nullable(false);
            $table->timestamps();
            $table->string('book_id', 20)->nullable(false);

            // Real primary key
            $table->unique(['name', 'book_id']);

            // Foregin keys
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
