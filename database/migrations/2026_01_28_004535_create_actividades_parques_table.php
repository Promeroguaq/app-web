<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('actividad_parques', function (Blueprint $table) {
            $table->id(); // ID interno Laravel

            $table->unsignedBigInteger('id_actividad')->unique();
            $table->string('nombre_actividad_en_parque', 255);
            $table->unsignedBigInteger('id_localitites');
            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividad_parques');
    }
};
