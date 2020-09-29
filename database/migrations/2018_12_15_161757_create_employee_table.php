<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clave', 10);
            $table->string('nss', 11);
            $table->integer('id_sucursal')->unsigned();
            $table->foreign('id_sucursal')->references('clave')->on('sucursales');
            $table->string('nombre',250);
            $table->string('apellidos',250);
            $table->string('turno',250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
