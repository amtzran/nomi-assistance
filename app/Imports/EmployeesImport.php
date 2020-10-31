<?php

namespace App\Imports;

use App\Employee;
use App\Branch;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    private $id_empresa;

    /**
     * BranchsImport constructor.
     * @param $id_empresa
     */

    /**
     * @param array $row
     * @return Employee
     */
    public function __construct($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }

    public function model(array $row)
    {
        $validationSucursal= Branch::where('clave', $row[2])->first();
        if(!empty($validationSucursal)){
            return new Employee([
                'clave' => $row[0],
                'nss' => $row[1],
                'id_sucursal' => $row[2],
                'nombre' => $row[3],
                'apellido_paterno' => $row[4],
                'apellido_materno' => $row[5],
                'id_turno' => $row[6],
                'id_empresa' => $this->id_empresa,
            ]);
        }
    }
}
