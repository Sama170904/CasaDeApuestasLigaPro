<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCantidadToApuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apuestas', function (Blueprint $table) {
            $table->integer('cantidad')->default(0)->after('prediccion');
        });
    }

    public function down()
    {
        Schema::table('apuestas', function (Blueprint $table) {
            $table->dropColumn('cantidad');
        });
    }

}
