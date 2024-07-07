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
        Schema::create('discounts', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->double('discount')->nullable(false);
            $table->string('name')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // Partial unique constraints
        DB::statement("CREATE UNIQUE INDEX unique_name ON discounts(name) WHERE deleted_at IS NULL;");

        // Value range constraints
        DB::statement("ALTER TABLE discounts ADD CONSTRAINT chk_discount_value CHECK (discount >= 0 AND discount <= 100)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
