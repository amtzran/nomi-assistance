<?php

namespace App\Imports;

use App\Employee;
use App\Branch;
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
        $validationSucursal= Branch::find($row[2]);
        if($validationSucursal){
            return new Employee([
                'clave' => $row[0],
                'nss' => $row[1],
                'id_sucursal' => $row[2],
                'nombre' => $row[3],
                'apellido_paterno' => $row[4],
                'apellido_materno' => $row[5],
                'turno' => $row[6],
                'id_empresa' => 1,
                'huella' => "cadenadehuella",
                'url_imagen' => "url.com",
            ]);
        }
    }
}
