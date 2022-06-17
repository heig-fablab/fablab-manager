<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            // Fields
            $table->string('title');
            $table->longText('description')->nullable();
            $table->date('deadline');
            $table->tinyInteger('rating')->nullable();
            $table->float('working_hour', 3, 1, true)->nullable(); // unsigned
            $table->enum('status', ['new', 'validated', 'assigned', 'ongoing', 'on-hold', 'completed', 'closed'])->default('new');
            // Options
            $table->timestamps();
            // Foreign keys
            $table->string('client_switch_uuid');
            $table->string('worker_switch_uuid')->nullable(); // Nullable because can / must be attributed later
            $table->string('validator_switch_uuid')->nullable(); // Nullable because can / must be attributed later

            $table->foreignId('job_category_id')->constrained();

            $table->foreign('client_switch_uuid')->references('switch_uuid')->on('users')->onDelete('cascade');
            $table->foreign('worker_switch_uuid')->references('switch_uuid')->on('users')->onDelete('cascade');
            $table->foreign('validator_switch_uuid')->references('switch_uuid')->on('users')->onDelete('cascade');
            // Indexes
            $table->index('job_category_id');
            $table->index('client_switch_uuid');
            $table->index('worker_switch_uuid');
            $table->index('validator_switch_uuid');
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('jobs');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
