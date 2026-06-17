<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reserva_parques', function (Blueprint $table) {
            $table->id(); // ID_RESERVAS
            $table->string('nombre');
            $table->unsignedBigInteger('locality_id');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('region_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva_parques');
    }
};
