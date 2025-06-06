<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarcadoresToEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->unsignedTinyInteger('marcador_local')->nullable();
            $table->unsignedTinyInteger('marcador_visitante')->nullable();
        });
    }

    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn(['marcador_local', 'marcador_visitante']);
        });
    }

}
