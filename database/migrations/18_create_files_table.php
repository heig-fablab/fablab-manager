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
            $table->unsignedBigInteger('id_file_type');
            $table->unsignedBigInteger('id_job');
            $table->string('name');
            $table->string('hash_name');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_file_type')->references('id')->on('file_types');
            $table->foreign('id_job')->references('id')->on('jobs');
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
