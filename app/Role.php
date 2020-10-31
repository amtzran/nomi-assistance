<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Role
 *
 * @property int $id
 * @property int $rol
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereRol($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Role extends Model
{
    // Model for table Role
    protected $table = 'roles';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'rol'];
}
