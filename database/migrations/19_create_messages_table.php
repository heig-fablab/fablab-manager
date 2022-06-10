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
            // Fields
            $table->longText('text');
            // Options
            $table->softDeletes();
            $table->timestamps();
            // Foreign keys
            $table->string('sender_switch_uuid');
            $table->string('receiver_switch_uuid');

            $table->foreignId('job_id')->constrained()->onDelete('cascade');

            $table->foreign('sender_switch_uuid')->references('switch_uuid')->on('users')->onDelete('cascade');
            $table->foreign('receiver_switch_uuid')->references('switch_uuid')->on('users')->onDelete('cascade');
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
