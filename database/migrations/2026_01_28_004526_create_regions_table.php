<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id(); // ID_REGION
            $table->string('nombre_region', 150);
            $table->unsignedBigInteger('locality_id'); // ID_LOCALITIES
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // Foreign key (si existe la tabla localities)
            $table->foreign('locality_id')
                  ->references('id')
                  ->on('localities')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
