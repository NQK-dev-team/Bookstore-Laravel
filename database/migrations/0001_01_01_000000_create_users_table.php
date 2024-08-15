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
        // ------------------------- User table -------------------------
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('password')->nullable(false);
            $table->string('address', 1000)->nullable();
            $table->date('dob')->nullable(false);
            $table->string('phone', 10)->nullable(false);
            $table->string('image', 1000)->nullable();
            $table->string('gender', 1)->nullable(false);
            $table->boolean('is_admin')->default(false)->nullable(false);
            $table->double('points')->nullable()->default(0);
            $table->string('referrer_id', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
            // $table->rememberToken();
            $table->timestamps();
        });

        // If the user is an admin then the following columns must be not null
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_admin_not_null_address CHECK (NOT is_admin OR (is_admin AND address IS NOT NULL))");
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_admin_not_null_img CHECK (NOT is_admin OR (is_admin AND image IS NOT NULL))");

        // If the user is an admin then the following columns must be null
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_admin_null_points CHECK (NOT is_admin OR (is_admin AND points IS NULL))");
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_admin_null_referrer_id CHECK (NOT is_admin OR (is_admin AND referrer_id IS NULL))");
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_admin_null_deleted_at CHECK (NOT is_admin OR (is_admin AND deleted_at IS NULL))");


        Schema::table('users', function (Blueprint $table) {
            // Self referencing foreign key
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        // Partial unique constraints
        DB::statement("CREATE UNIQUE INDEX unique_email ON users(email) WHERE deleted_at IS NULL;");
        DB::statement("CREATE UNIQUE INDEX unique_phone ON users(phone) WHERE deleted_at IS NULL;");

        // Value range constraints
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_points_value CHECK (points >= 0)");
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_gender CHECK (gender IN ('M', 'F','O'))");

        // ------------------------- End of user table -------------------------

        // ------------------------- Delete Queue table -------------------------
        Schema::create('delete_queue', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('user_id', 20)->nullable(false)->unique();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        // ------------------------- End of delete queue table -------------------------

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('email_verify_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            // $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
            $table->string('user_id', 20)->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
