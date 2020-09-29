<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Model for table Role
    protected $table = 'roles';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'rol'];
}
