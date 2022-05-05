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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->unsignedBigInteger('file_type_id');
            $table->unsignedBigInteger('job_id');
            // Fields
            $table->string('name');
            $table->string('hash_name');
            // Options
            $table->softDeletes();
            $table->timestamps();
            // References on foreign keys
            $table->foreign('file_type_id')->references('id')->on('file_types');
            $table->foreign('job_id')->references('id')->on('jobs');
            // Indexes
            $table->index('file_type_id');
            $table->index('job_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
