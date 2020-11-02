<?php


namespace App;


use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Authentications
 *
 * @property int $id
 * @property int|null $nip
 * @property string|null $huella
 * @property string|null $rfid
 * @property int $clave_empleado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Authentications newModelQuery()
 * @method static Builder|Authentications newQuery()
 * @method static Builder|Authentications query()
 * @method static Builder|Authentications whereClaveEmpleado($value)
 * @method static Builder|Authentications whereCreatedAt($value)
 * @method static Builder|Authentications whereHuella($value)
 * @method static Builder|Authentications whereId($value)
 * @method static Builder|Authentications whereNip($value)
 * @method static Builder|Authentications whereRfid($value)
 * @method static Builder|Authentications whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Authentications extends Model
{
    // Model for table autenticaciones
    protected $table = 'autenticaciones';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'nip', 'huella', 'rfid', 'clave_empleado'];
}
