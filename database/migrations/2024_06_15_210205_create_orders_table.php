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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id',20)->primary();
            $table->boolean('status')->default(false)->nullable(false);
            $table->double('total_cost')->nullable(false)->default(0);
            $table->double('total_discount')->nullable(false)->default(0);
            $table->string('customer_id', 20)->nullable(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        // Value range constraints
        DB::statement("ALTER TABLE orders ADD CONSTRAINT chk_total_cost_value CHECK (total_cost >= 0)");
        DB::statement("ALTER TABLE orders ADD CONSTRAINT chk_total_discount_value CHECK (total_discount >= 0)");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
