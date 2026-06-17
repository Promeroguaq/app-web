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
        Schema::create('detalle_platos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plato_id')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('tiempo_preparacion')->nullable();
            $table->string('porciones')->nullable();
            $table->string('dificultad')->nullable();
            $table->string('fuente_nombre')->nullable();
            $table->string('fuente_url')->nullable();
            $table->date('fecha_consulta')->nullable();
            $table->enum('estado_verificacion', ['pendiente', 'investigado', 'verificado', 'publicado', 'rechazado'])->default('pendiente');
            $table->string('revisado_por')->nullable();
            $table->timestamps();
            
            $table->index('plato_id');
            $table->index('estado_verificacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_platos');
    }
};
