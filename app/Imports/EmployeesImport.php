<?php

namespace App\Imports;

use App\Authentications;
use App\Employee;
use App\Branch;
use App\Http\Controllers\EmployeeController;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

/**
 * Class EmployeesImport
 * @package App\Imports
 */
class EmployeesImport implements ToModel
{
    private $id_empresa;

    /**
     * EmployeesImport constructor.
     * @param $id_empresa
     */
    public function __construct($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }

    /**
     * @param array $row
     * @return Employee|Model|Model[]|null
     */
    public function model(array $row)
    {
        $validationSucursal= Branch::where('clave', $row[2])->first();
        if(!empty($validationSucursal)) {

            $authentication = new Authentications;
            $authentication->nip = EmployeeController::generatePIN();
            $authentication->clave_empleado = $row[0];
            $authentication->save();

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
