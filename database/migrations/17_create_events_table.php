<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            // Fields
            $table->enum('type', ['status', 'file', 'message']);
            $table->boolean('to_notify')->default(true);
            $table->string('data', 255)->nullable(); // to store status type and file name
            // Options
            $table->timestamps();
            $table->softDeletes();
            // Foreign keys
            $table->string('user_username', 17);
            $table->foreign('user_username')->references('username')->on('users')->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            // Indexes
            $table->index('job_id');
            $table->index('user_username');
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('events');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
