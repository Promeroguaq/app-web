<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('termales', function (Blueprint $table) {
            $table->id(); // ID_TERMALES
            $table->string('nombre'); // NOMBRE_TERMAL
            $table->unsignedBigInteger('locality_id'); // ID_LOCALITIES
            $table->text('descripcion')->nullable(); // DESCRIPCION
            $table->unsignedBigInteger('country_id'); // ID_COUNTRY
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('termales');
    }
};
