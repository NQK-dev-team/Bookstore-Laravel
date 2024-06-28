<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('physical_order_contains', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('order_id', 20)->nullable(false);
            $table->string('book_id', 20)->nullable(false);
            $table->integer('amount')->nullable(false)->default(1);
            $table->timestamps();

            // Real primary key
            $table->unique(['order_id', 'book_id']);

            // Foreign keys
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
        });

        // Value range constraints
        DB::statement("ALTER TABLE physical_order_contains ADD CONSTRAINT chk_amount_value CHECK (amount >= 1)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_order_contains');
    }
};
