<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tabla_municipios', function (Blueprint $table) {
            if (!Schema::hasColumn('tabla_municipios', 'ID_DEPARTAMENTO')) {
                $table->integer('ID_DEPARTAMENTO')->nullable()->after('ID_MUNICIPIOS');
                $table->index('ID_DEPARTAMENTO');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tabla_municipios', function (Blueprint $table) {
            if (Schema::hasColumn('tabla_municipios', 'ID_DEPARTAMENTO')) {
                $table->dropIndex(['ID_DEPARTAMENTO']);
                $table->dropColumn('ID_DEPARTAMENTO');
            }
        });
    }
};
