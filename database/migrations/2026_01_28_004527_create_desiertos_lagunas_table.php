<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('desierto_lagunas', function (Blueprint $table) {
            $table->id(); // ID interno Laravel
            $table->unsignedBigInteger('id_desierto')->unique();
            $table->string('nombre_desierto_lagunas', 255);
            $table->unsignedBigInteger('id_localities');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desierto_lagunas');
    }
};
