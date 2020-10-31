<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Employee
 *
 * @property int $id
 * @property string $clave
 * @property string $nss
 * @property int $id_sucursal
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $id_turno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $apellido_materno
 * @property int $id_empresa
 * @property string|null $huella
 * @property string|null $url_imagen
 * @method static Builder|Employee newModelQuery()
 * @method static Builder|Employee newQuery()
 * @method static Builder|Employee query()
 * @method static Builder|Employee whereApellidoMaterno($value)
 * @method static Builder|Employee whereApellidoPaterno($value)
 * @method static Builder|Employee whereClave($value)
 * @method static Builder|Employee whereCreatedAt($value)
 * @method static Builder|Employee whereHuella($value)
 * @method static Builder|Employee whereId($value)
 * @method static Builder|Employee whereIdEmpresa($value)
 * @method static Builder|Employee whereIdSucursal($value)
 * @method static Builder|Employee whereIdTurno($value)
 * @method static Builder|Employee whereNombre($value)
 * @method static Builder|Employee whereNss($value)
 * @method static Builder|Employee whereUpdatedAt($value)
 * @method static Builder|Employee whereUrlImagen($value)
 * @mixin Eloquent
 */
class Employee extends Model
{
    // Model for table Employees
    protected $table = 'empleados';
    protected $primarykey = 'id';
    protected $fillable = ['id','clave','nss','id_sucursal','nombre', 'apellido_paterno','apellido_materno',
        'id_turno','id_empresa','huella','url_imagen'];
}
