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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->string('user_switch_uuid');
            $table->unsignedBigInteger('role_id');
            // References on foreign keys
            $table->foreign('user_switch_uuid')->references('switch_uuid')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
            // Indexes
            $table->index('user_switch_uuid');
            $table->index('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
};