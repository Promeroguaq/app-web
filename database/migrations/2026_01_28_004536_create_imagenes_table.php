<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id(); // id (ID_IMAGEN)
            $table->string('nombre_imagen');
            $table->unsignedBigInteger('locality_id'); // ID_LOCALITIES
            $table->string('ruta');
            $table->timestamps();

            // FK opcional (si existe la tabla localities)
            // $table->foreign('locality_id')->references('id')->on('localities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};
