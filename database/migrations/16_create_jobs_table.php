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
            // Foreign keys
            $table->unsignedBigInteger('category_id');
            $table->string('client_switch_uuid');
            $table->string('worker_switch_uuid')->nullable(); // Because can / must be attributed later
            $table->string('validator_switch_uuid')->nullable(); // Because can / must be attributed later
            // Fields
            $table->string('title');
            $table->longText('description')->nullable();
            $table->date('deadline');
            $table->tinyInteger('rating')->nullable();
            $table->enum('status', ['new', 'validated', 'assigned', 'ongoing', 'on-hold','completed'])->default('new');
            $table->softDeletes();
            $table->timestamps();
            // References on foreign keys
            $table->foreign('category_id')->references('id')->on('job_categories');
            $table->foreign('client_switch_uuid')->references('switch_uuid')->on('users');
            $table->foreign('worker_switch_uuid')->references('switch_uuid')->on('users');
            $table->foreign('validator_switch_uuid')->references('switch_uuid')->on('users');
            // Indexes
            $table->index('category_id');
            $table->index('client_switch_uuid');
            $table->index('worker_switch_uuid');
            $table->index('validator_switch_uuid');
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
