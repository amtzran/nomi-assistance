<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    // Model for table Branches
    protected $table = 'turnos';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'nombre_turno', 'hora_entrada','hora_salida','id_empresa'];
}
