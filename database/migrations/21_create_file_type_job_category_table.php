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
        Schema::create('file_type_job_category', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->foreignId('job_category_id')->constrained('job_categories')->onDelete('cascade');
            $table->foreignId('file_type_id')->constrained()->onDelete('cascade');
            // Indexes
            $table->index('job_category_id');
            $table->index('file_type_id');
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
        Schema::dropIfExists('file_type_job_category');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
