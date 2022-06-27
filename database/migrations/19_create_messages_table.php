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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // Fields
            $table->longText('text');
            // Options
            $table->softDeletes();
            $table->timestamps();
            // Foreign keys
            $table->string('sender_username', 17);
            $table->string('receiver_username', 17);

            $table->foreignId('job_id')->constrained()->onDelete('cascade');

            $table->foreign('sender_username')->references('username')->on('users')->onDelete('cascade');
            $table->foreign('receiver_username')->references('username')->on('users')->onDelete('cascade');
            // Indexes
            $table->index('job_id');
            $table->index('sender_username');
            $table->index('receiver_username');
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
        Schema::dropIfExists('messages');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
