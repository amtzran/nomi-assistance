<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Branch
 *
 * @property int $id
 * @property int $clave
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id_empresa
 * @method static Builder|Branch newModelQuery()
 * @method static Builder|Branch newQuery()
 * @method static Builder|Branch query()
 * @method static Builder|Branch whereClave($value)
 * @method static Builder|Branch whereCreatedAt($value)
 * @method static Builder|Branch whereId($value)
 * @method static Builder|Branch whereIdEmpresa($value)
 * @method static Builder|Branch whereNombre($value)
 * @method static Builder|Branch whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Branch extends Model
{
    // Model for table Branches
    protected $table = 'sucursales';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'clave', 'nombre','id_empresa'];
}
