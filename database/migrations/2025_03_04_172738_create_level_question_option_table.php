<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('level_question_option', function (Blueprint $table) {
            $table->id();
            $table->integer("level_id")->nullable();
            $table->integer("level_question_id")->nullable();
            $table->string("name")->nullable();
            $table->boolean("correct")->default(false);
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('level_question_option');
    }
};
