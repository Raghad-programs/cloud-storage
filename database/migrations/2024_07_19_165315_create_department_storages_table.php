<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('department_storages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('file_type')->constrained('file_types');
            $table->string('file');
            $table->string('file_size');
            $table->foreignId('user_id')->constrained('users');
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_storages');
    }
};
