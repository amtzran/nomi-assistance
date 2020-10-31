<?php

namespace App\Imports;

use App\Assistance;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

/**
 * Class AssistancesImport
 * @package App\Imports
 */
class AssistancesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        return new Assistance([
            'id_empleado' => $row[0],
            'asistencia' => $row[1],
        ]);
    }
}
