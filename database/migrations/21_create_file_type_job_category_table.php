<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('file_type_id');
            // References on foreign keys
            $table->foreign('category_id')->references('id')->on('job_categories');
            $table->foreign('file_type_id')->references('id')->on('file_types');
            // Indexes
            $table->index('category_id');
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
        Schema::dropIfExists('file_type_job_category');
    }
};
