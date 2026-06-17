<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->id('id_municipios');
            $table->string('nombre_municipios');
            $table->unsignedBigInteger('id_localities');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // FK opcional (si existe tabla localities)
            // $table->foreign('id_localities')->references('id')->on('localities');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};
