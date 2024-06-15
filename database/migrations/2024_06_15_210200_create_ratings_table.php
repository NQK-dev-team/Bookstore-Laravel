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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('book_id', 20)->nullable(false);
            $table->string('customer_id', 20)->nullable(false);
            $table->integer('star')->nullable(false);
            $table->string('comment', 1000)->nullable();
            $table->timestamps();

            // Real primary key
            $table->unique(['book_id', 'customer_id']);

            // Foreign keys
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
        });

        // Other constraints
        DB::statement("ALTER TABLE ratings ADD CONSTRAINT chk_star_value CHECK (star >= 0 AND star <= 5)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
