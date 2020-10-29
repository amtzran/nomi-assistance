<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutenticacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nip')->nullable();
            $table->string('huella')->nullable();
            $table->string('rfid')->nullable();
            $table->integer('clave_empleado')->unsigned();
            $table->foreign('clave_empleado')->references('clave')->on('empleados');
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
        Schema::dropIfExists('autenticaciones');
    }
}
