<?php

namespace App\Exports;
use DB;

use App\Assistance;
use Maatwebsite\Excel\Concerns\FromCollection;

class AssistancesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $assistances = DB::table('asistencia as a')
            ->join('empleados as e', 'a.id_clave', 'e.clave')
            ->join('ausencias as au', 'a.asistencia', 'au.id')
            ->select('e.clave', 'e.nss', 'e.nombre', 'e.apellido_paterno', 'au.nombre as nombre_incidencia',
                'a.hora_entrada', 'a.hora_salida', 'a.fecha_entrada')
            ->get();

        $assistances->prepend([
            'Clave',
            'Nss',
            'Nombre',
            'Apellido',
            'Asistencia',
            'Hora Entrada',
            'Hora Salida',
            'Fecha'            
        ]);
        return $assistances;
    }
}
