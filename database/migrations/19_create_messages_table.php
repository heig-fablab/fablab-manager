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
            // Foreign keys
            $table->unsignedBigInteger('job_id');
            $table->string('sender_switch_uuid');
            $table->string('receiver_switch_uuid');
            // Fields
            $table->longText('text');
            // Options
            $table->timestamps();
            // References on foreign keys
            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('sender_switch_uuid')->references('switch_uuid')->on('users');
            $table->foreign('receiver_switch_uuid')->references('switch_uuid')->on('users');
            // Indexes
            $table->index('job_id');
            $table->index('sender_switch_uuid');
            $table->index('receiver_switch_uuid');
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
