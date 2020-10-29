<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class EmployeesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $employees = DB::table('empleados as e')
        // 3 parametros tabla a hacer join,1 tabla a asociar, 2 campo de relacion, 3 campo id del tabla sucursal
            ->join('sucursales as s','e.id_sucursal','s.clave')
            ->join('turnos as t','e.id_turno','t.id')
            ->select('e.id','e.clave','e.nss','s.nombre as sucursal','e.nombre', 'e.apellido_paterno','e.apellido_materno', 't.nombre_turno as turno')
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
