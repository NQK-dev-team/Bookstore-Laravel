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
        Schema::create('physical_copies', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->double('price')->nullable();
            $table->integer('quantity')->nullable()->default(0);
            $table->timestamps();

            // Foreign keys
            $table->foreign('id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');

        });

        // Value range constraints
        DB::statement("ALTER TABLE physical_copies ADD CONSTRAINT chk_price_value CHECK (price >= 0)");
        DB::statement("ALTER TABLE physical_copies ADD CONSTRAINT chk_quantity_value CHECK (quantity >= 0)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_copies');
    }
};
