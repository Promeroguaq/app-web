<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ciclismo', function (Blueprint $table) {
            $table->id(); // ID_CICLISMO
            $table->string('nombre_ruta_ciclismo');
            $table->unsignedBigInteger('locality_id');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // Relación opcional con tabla localidades si existe
            // $table->foreign('locality_id')->references('id')->on('localities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ciclismo');
    }
};
