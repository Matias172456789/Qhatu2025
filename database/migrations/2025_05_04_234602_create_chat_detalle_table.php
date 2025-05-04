<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chat_detalle', function (Blueprint $table) {
            $table->id();
            $table->integer('chat_header_id');
            $table->text('mensaje')->nullable();
            $table->boolean('bot')->default(false)->comment('Indica si el mensaje fue enviado por el bot');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_detalle');
    }
};
