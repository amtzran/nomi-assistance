<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    // Model for table assistance
    protected $table = 'asistencia';
    protected $primarykey = 'id';
    protected $fillable = ['id','id_empleado','asistencia'];
}
