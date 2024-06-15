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
        Schema::create('customers', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->double('point')->nullable(false)->default(0);
            $table->string('referrer_id', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('customers', function (Blueprint $table) {
            // Self referencing foreign key
            $table->foreign('referrer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
        });

        // Other constraints
        DB::statement("ALTER TABLE customers ADD CONSTRAINT chk_point_value CHECK (point >= 0)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
