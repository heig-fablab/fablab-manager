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
        Schema::create('job_category_has_file_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job_category');
            $table->unsignedBigInteger('id_file_type');

            $table->foreign('id_job_category')->references('id')->on('job_categories');
            $table->foreign('id_file_type')->references('id')->on('file_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_category_has_file_type');
    }
};
