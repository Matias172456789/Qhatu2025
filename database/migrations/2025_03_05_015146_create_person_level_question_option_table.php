<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('person_level_question_option', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->integer('level_id');
            $table->integer('level_question_id');
            $table->integer('level_question_option_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person_level_question_option');
    }
};
