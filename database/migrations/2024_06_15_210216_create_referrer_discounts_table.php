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
        Schema::create('referrer_discounts', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->integer('number_of_people')->nullable(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('id')->references('id')->on('discounts')->onDelete('cascade')->onUpdate('cascade');
        });

        // Value range constraints
        DB::statement("ALTER TABLE referrer_discounts ADD CONSTRAINT chk_number_of_people_value CHECK (number_of_people >= 0)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrer_discounts');
    }
};
