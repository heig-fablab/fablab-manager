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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->date('deadline');
            $table->tinyInteger('rating')->nullable();
            $table->enum('status', ['new', 'assigned', 'ongoing', 'on-hold','completed'])->default('new');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_category')->references('id')->on('job_categories');
            $table->foreign('requestor_email')->references('email')->on('users');
            $table->foreign('worker_email')->references('email')->on('users');
            $table->foreign('validator_email')->references('email')->on('users')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
