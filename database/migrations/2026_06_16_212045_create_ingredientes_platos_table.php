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
        Schema::create('ingredientes_platos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plato_id')->nullable();
            $table->string('nombre');
            $table->string('cantidad')->nullable();
            $table->string('unidad')->nullable();
            $table->text('observacion')->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();
            
            $table->index('plato_id');
            $table->index('orden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredientes_platos');
    }
};
