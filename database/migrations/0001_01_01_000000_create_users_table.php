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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name')->nullable(false);
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('address', 1000)->nullable();
            $table->date('dob')->nullable(false);
            $table->string('phone', 10)->nullable();
            $table->string('image')->nullable();
            $table->char('gender')->nullable(false);
            $table->rememberToken();
            $table->timestamps();
        });

        // Other constraints for the users table
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_gender CHECK (gender IN ('M', 'F','O'))");

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
