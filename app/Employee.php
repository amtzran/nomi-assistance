<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Model for table Employees
    protected $table = 'empleados';
    protected $primarykey = 'id';
    protected $fillable = ['id','clave','nss','id_sucursal','nombre', 'apellido_paterno','apellido_materno', 'turno','id_empresa','huella','url_imagen'];
}
