<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('deportes_aventura', function (Blueprint $table) {
            $table->id(); // ID_DEPORTES
            $table->string('nombre');
            $table->unsignedBigInteger('locality_id'); // ID_LOCALITIES
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // FK (si existe tabla localities)
            $table->foreign('locality_id')
                  ->references('id')
                  ->on('localities')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deportes_aventura');
    }
};