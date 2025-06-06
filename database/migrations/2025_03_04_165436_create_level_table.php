<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('level', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('description',255)->nullable();
            $table->string('link')->nullable();
            $table->integer('minim_calification')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('level');
    }
};
