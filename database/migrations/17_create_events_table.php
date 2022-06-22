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
            $table->string('data', 12)->nullable(); // to store status type
            // Options
            $table->timestamps();
            $table->softDeletes();
            // Foreign keys
            $table->string('user_switch_uuid');
            $table->foreign('user_switch_uuid')->references('switch_uuid')->on('users')->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            // Indexes
            $table->index('job_id');
            $table->index('user_switch_uuid');
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('events');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
