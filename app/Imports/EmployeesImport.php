<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            'clave' => $row[0],
            'nss' => $row[1],
            'id_sucursal' => $row[2],
            'nombre' => $row[3],
            'apellidos' => $row[4],
            'turno' => $row[5],
        ]);
    }
}
