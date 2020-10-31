<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Assistance
 *
 * @property int $id
 * @property int $asistencia
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $entrada
 * @property int|null $salida
 * @property string|null $hora_entrada
 * @property string|null $hora_salida
 * @property string|null $fecha_entrada
 * @property string|null $fecha_salida
 * @property int $id_clave
 * @property string $geolocalizacion
 * @method static Builder|Assistance newModelQuery()
 * @method static Builder|Assistance newQuery()
 * @method static Builder|Assistance query()
 * @method static Builder|Assistance whereAsistencia($value)
 * @method static Builder|Assistance whereCreatedAt($value)
 * @method static Builder|Assistance whereEntrada($value)
 * @method static Builder|Assistance whereFechaEntrada($value)
 * @method static Builder|Assistance whereFechaSalida($value)
 * @method static Builder|Assistance whereGeolocalizacion($value)
 * @method static Builder|Assistance whereHoraEntrada($value)
 * @method static Builder|Assistance whereHoraSalida($value)
 * @method static Builder|Assistance whereId($value)
 * @method static Builder|Assistance whereIdClave($value)
 * @method static Builder|Assistance whereSalida($value)
 * @method static Builder|Assistance whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Assistance extends Model
{
    // Model for table assistance
    protected $table = 'asistencia';
    protected $primarykey = 'id';
    protected $fillable = ['id','id_empleado','asistencia'];
}
