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
        Schema::create('belongs_to', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('book_id', 20)->nullable(false);
            $table->string('author_id', 20)->nullable(false);
            $table->timestamps();

            // Real primary key
            $table->unique(['book_id', 'author_id']);

            // Foreign keys
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('belongs_to');
    }
};
