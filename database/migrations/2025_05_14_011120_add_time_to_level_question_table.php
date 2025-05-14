<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('level_question', function (Blueprint $table) {
            $table->string('time_response')->nullable()->after('question')->comment('Tiempo estimado de la respuesta');
        });
    }

    public function down(): void
    {
        Schema::table('level_question', function (Blueprint $table) {
            $table->dropColumn('time_response');
        });
    }
};
