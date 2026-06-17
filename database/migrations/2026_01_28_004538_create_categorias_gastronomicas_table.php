<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias_gastronomicas', function (Blueprint $table) {
            $table->id('id_categoria_gastronomica'); // ID_CATEGORIA_GASTRONÓMICA
            $table->string('nombre_categoria_gastronomica'); // NOMBRE_CATEGORIA_GASTRONÓMICA
            $table->unsignedBigInteger('id_localities'); // ID_LOCALITIES
            $table->timestamps();

            // Si quieres agregar relación con la tabla `localities`:
            // $table->foreign('id_localities')->references('id')->on('localities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_gastronomicas');
    }
};
