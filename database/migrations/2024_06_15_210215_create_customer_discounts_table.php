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
        Schema::create('customer_discounts', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->double('point')->nullable(false);
            $table->double('discount')->nullable(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('id')->references('id')->on('discounts')->onDelete('cascade')->onUpdate('cascade');
        });

        // Value range constraints
        DB::statement("ALTER TABLE customer_discounts ADD CONSTRAINT chk_point_value CHECK (point >= 0)");
        DB::statement("ALTER TABLE customer_discounts ADD CONSTRAINT chk_discount_value CHECK (discount >= 0 AND discount <= 100)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_discounts');
    }
};
