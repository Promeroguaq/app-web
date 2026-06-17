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
        Schema::table('tabla_imagenes', function (Blueprint $table) {
            // Columnas polimórficas para relacionar con cualquier entidad
            $table->unsignedBigInteger('imageable_id')->nullable();
            $table->string('imageable_type')->nullable();
            
            // Categoría de la imagen (paisajes, cultura, gastronomia, naturaleza, eventos)
            $table->string('categoria')->nullable();
            
            // Indica si es la imagen principal de la entidad
            $table->boolean('principal')->default(false);
            
            // Orden de visualización
            $table->integer('orden')->default(0);
            
            // Índices para búsquedas eficientes
            $table->index(['imageable_id', 'imageable_type']);
            $table->index('categoria');
            $table->index('principal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tabla_imagenes', function (Blueprint $table) {
            $table->dropIndex(['imageable_id', 'imageable_type']);
            $table->dropIndex('categoria');
            $table->dropIndex('principal');
            $table->dropColumn(['imageable_id', 'imageable_type', 'categoria', 'principal', 'orden']);
        });
    }
};
