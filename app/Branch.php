<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    // Model for table Branches
    protected $table = 'sucursales';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'clave', 'nombre'];
}
