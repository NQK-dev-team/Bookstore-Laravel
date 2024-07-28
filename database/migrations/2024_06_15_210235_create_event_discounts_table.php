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
        Schema::create('event_discounts', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->dateTime('start_time')->nullable(false);
            $table->dateTime('end_time')->nullable(false);
            $table->boolean('apply_for_all_books')->nullable(false)->default(false);
            $table->boolean('is_notified')->nullable(false)->default(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('id')->references('id')->on('discounts')->onDelete('cascade')->onUpdate('cascade');
        });

        // Value range constraints
        DB::statement("ALTER TABLE event_discounts ADD CONSTRAINT chk_start_time_end_end CHECK (start_time <= end_time)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_discounts');
    }
};
