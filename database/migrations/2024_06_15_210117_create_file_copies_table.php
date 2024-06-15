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
        Schema::create('file_copies', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->double('price')->nullable();
            $table->string('path', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
        });

        // Other constraints
        DB::statement("ALTER TABLE file_copies ADD CONSTRAINT chk_price_value CHECK (price >= 0)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_copies');
    }
};
