<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeyToAsistenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asistencia', function (Blueprint $table) {
            // 
            $table->dropColumn('id_empleado');
            $table->integer('id_clave')->unsigned();
            $table->foreign('id_clave')->references('clave')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asistencia', function (Blueprint $table) {
            //
        });
    }
}
