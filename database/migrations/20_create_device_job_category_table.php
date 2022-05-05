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
        Schema::create('device_job_category', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('device_id');
            // References on foreign keys
            $table->foreign('category_id')->references('id')->on('job_categories');
            $table->foreign('device_id')->references('id')->on('devices');
            // Indexes
            $table->index('category_id');
            $table->index('device_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_job_category');
    }
};
