<?php

namespace App\Imports;

use App\Assistance;
use Maatwebsite\Excel\Concerns\ToModel;

class AssistancesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Assistance([
            'id_empleado' => $row[0],
            'asistencia' => $row[1],
        ]);
    }
}
