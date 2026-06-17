<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('museos', function (Blueprint $table) {
            $table->id('id_museo');
            $table->string('nombre_museo', 255);
            $table->unsignedBigInteger('id_localities');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('id_country');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('museos');
    }
};
