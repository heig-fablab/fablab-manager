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
        Schema::create('users', function (Blueprint $table) {
            $table->string('switch_uuid', 320)->unique()->primary();
            // Fields
            $table->string('email', 320)->unique();
            $table->string('name');
            $table->string('surname');
            $table->string('password')->nullable();
            $table->boolean('require_status_email')->default(true);
            $table->boolean('require_files_email')->default(true);
            $table->boolean('require_messages_email')->default(true);
            $table->timestamp('last_email_sent')->useCurrent()->nullable();
            // Options
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
