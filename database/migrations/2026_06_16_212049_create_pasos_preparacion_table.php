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
        Schema::create('pasos_preparacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plato_id')->nullable();
            $table->integer('orden');
            $table->text('instruccion');
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
        Schema::dropIfExists('pasos_preparacion');
    }
};
