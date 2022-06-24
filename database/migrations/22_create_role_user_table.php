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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->string('user_username', 17);
            $table->foreign('user_username')->references('username')->on('users')->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            // Indexes
            $table->index('user_username');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('role_user');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
