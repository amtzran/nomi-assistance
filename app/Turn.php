<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Turn
 *
 * @property int $id
 * @property string $nombre_turno
 * @property string|null $hora_entrada
 * @property string|null $hora_salida
 * @property int $id_empresa
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Turn newModelQuery()
 * @method static Builder|Turn newQuery()
 * @method static Builder|Turn query()
 * @method static Builder|Turn whereCreatedAt($value)
 * @method static Builder|Turn whereHoraEntrada($value)
 * @method static Builder|Turn whereHoraSalida($value)
 * @method static Builder|Turn whereId($value)
 * @method static Builder|Turn whereIdEmpresa($value)
 * @method static Builder|Turn whereNombreTurno($value)
 * @method static Builder|Turn whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Turn extends Model
{
    // Model for table Branches
    protected $table = 'turnos';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'nombre_turno', 'hora_entrada','hora_salida','id_empresa'];
}
