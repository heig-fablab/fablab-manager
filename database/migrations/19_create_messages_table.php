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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job');
            $table->string('sender_email');
            $table->string('receiver_email');
            $table->longText('text');
            $table->timestamps();

            $table->foreign('id_job')->references('id')->on('jobs');
            $table->foreign('sender_email')->references('email')->on('users');
            $table->foreign('receiver_email')->references('email')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};