<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            // Fields
            $table->string('name', 255);
            $table->string('hash', 64);
            $table->string('directory', 2);
            // Options
            $table->timestamps();
            // Foreign keys
            $table->foreignId('file_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('job_category_id')->constrained();
            // Indexes
            $table->index('file_type_id');
            $table->index('job_id');
            $table->index('job_category_id');
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('files');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
