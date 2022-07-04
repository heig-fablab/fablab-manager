<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            // Fields
            $table->string('acronym', 3)->unique();
            $table->string('name', 50);
            $table->text('description');
            // Foreign keys
            $table->foreignId('file_id')->constrained('file')->onDelete('cascade');
            // Indexes
            $table->index('file_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('job_categories');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
