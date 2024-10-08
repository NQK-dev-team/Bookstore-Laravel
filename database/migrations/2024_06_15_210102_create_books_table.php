<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name', 255)->nullable(false);
            $table->integer('edition')->nullable(false)->default(1);
            $table->string('isbn', 13)->nullable(false);
            $table->double('average_rating')->nullable(false)->default(0);
            $table->string('publisher', 255)->nullable(false);
            $table->date('publication_date')->nullable(false);
            $table->string('image', 1000)->nullable(false);
            $table->string('description', 2000)->nullable();
            $table->boolean('status')->nullable(false)->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        // Partial unique constraints
        DB::statement("CREATE UNIQUE INDEX unique_name_edition ON books(name, edition) WHERE deleted_at IS NULL;");
        DB::statement("CREATE UNIQUE INDEX unique_isbn ON books(isbn) WHERE deleted_at IS NULL;");

        // Value range constaints
        DB::statement("ALTER TABLE books ADD CONSTRAINT chk_average_rating CHECK (average_rating >= 0 AND average_rating <= 5)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
