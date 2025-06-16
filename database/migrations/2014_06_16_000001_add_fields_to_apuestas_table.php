<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToApuestasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('apuestas', function (Blueprint $table) {
            // Nuevos campos
            $table->integer('marcador_local')->nullable()->after('prediccion');
            $table->integer('marcador_visitante')->nullable()->after('marcador_local');
            $table->string('total_goles')->nullable()->after('marcador_visitante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apuestas', function (Blueprint $table) {
            $table->dropColumn(['marcador_local', 'marcador_visitante', 'total_goles']);
        });
    }
}
