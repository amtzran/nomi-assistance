<?php

namespace App\Exports;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

/**
 * Class AssistancesExport
 * @package App\Exports
 */
class AssistancesExport implements FromCollection
{
    private $filter;
    private $initial_date;
    private $final_date;

    /**
     * AssistancesExport constructor.
     * @param $filter
     * @param $initial_date
     * @param $final_date
     */
    public function __construct($filter, $initial_date, $final_date)
    {
        $this->filter = $filter;
        $this->initial_date = $initial_date;
        $this->final_date = $final_date;
    }
    /**
     * Exporta una colección de empleados a excel.
     * @return Collection
     */
    public function collection()
    {
        $assistances = DB::table('asistencia as a')
            ->join('empleados as e', 'a.id_clave', 'e.clave')
            ->join('ausencias as au', 'a.asistencia', 'au.id')
            ->select('e.clave', 'e.nss', 'e.nombre', 'e.apellido_paterno', 'au.nombre as nombre_incidencia',
                'a.hora_entrada', 'a.hora_salida', 'a.fecha_entrada');

        if ($this->filter === 1){
            $date = Carbon::now();
            $date = $date->toFormattedDateString();
            $assistances->where("a.fecha_entrada", $date);
        }
        else if ($this->filter === 3) {
            $assistances
                ->whereDate("a.fecha_entrada", '>=', $this->initial_date)
                ->whereDate('a.fecha_entrada', '<=', $this->final_date);
        }

        $data = $assistances->get();

        $data->prepend([
            'Clave',
            'Nss',
            'Nombre',
            'Apellido',
            'Asistencia',
            'Hora Entrada',
            'Hora Salida',
            'Fecha'
        ]);
        return $data;
    }
}
