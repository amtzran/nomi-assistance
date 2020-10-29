<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class EmployeesExport implements FromCollection
{

    private $id_empresa;

    /**
     * EmployeesExport constructor.
     * @param $id_empresa
     */
    public function __construct($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $employees = DB::table('empleados as e')
            ->join('sucursales as s','e.id_sucursal','s.clave')
            ->join('turnos as t','e.id_turno','t.id')
            ->select('e.id','e.clave','e.nss','s.nombre as sucursal','e.nombre', 'e.apellido_paterno',
                'e.apellido_materno', 't.nombre_turno as turno', 'e.id_empresa')
            ->where('e.id_empresa', $this->id_empresa)
            ->get();
        $employees->prepend([
            'Id',
            'Clave',
            'Nss',
            'Sucursal',
            'Nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Turno'
        ]);
        return $employees;
    }
}
