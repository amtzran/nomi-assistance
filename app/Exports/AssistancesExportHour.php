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
class AssistancesExportHour implements FromCollection
{
    private $initial_date;
    private $final_date;
    private $id_company;
    private $id_employee;

    /**
     * AssistancesExport constructor.
     * @param $initial_date
     * @param $final_date
     * @param $id_company
     * @param $id_employee
     */
    public function __construct($initial_date, $final_date, $id_company, $id_employee)
    {
        $this->initial_date = $initial_date;
        $this->final_date = $final_date;
        $this->id_company = $id_company;
        $this->id_employee = $id_employee;
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
            ->join('turnos as t','e.id_turno','t.id')
            ->select('e.clave', 'e.nss', 'e.nombre', 'e.apellido_paterno', 'a.fecha_entrada',
                'a.hora_entrada', 'a.hora_salida', 't.hora_entrada as hora_entrada_turno','t.hora_salida as hora_salida_turno')
            ->where('e.id_empresa', $this->id_company)
            ->where('a.entrada' ,1)
            ->where('a.salida' ,1)
            ->whereDate("a.fecha_entrada", '>=', $this->initial_date)
            ->whereDate('a.fecha_entrada', '<=', $this->final_date);

        if ($this->id_employee != 0) $assistances->where("e.id", $this->id_employee);

        $datas = $assistances->get();

        $totalMinutes = 0;
        foreach ($datas as $data) {
            $hoursOutEmployee = Carbon::parse($data->hora_salida);
            $hoursOutTurn = Carbon::parse($data->hora_salida_turno);
            $minutes = $hoursOutTurn->diffInMinutes($hoursOutEmployee);
            $totalMinutes += $minutes;
            $data->hours = intdiv($minutes, 60).':'. ($minutes % 60);
            $data->minutes = $minutes;
        }

        $datas->prepend([
            'Clave',
            'Nss',
            'Nombre',
            'Apellido',
            'Fecha',
            'Hora Entrada',
            'Hora Salida',
            'Hora Entrada Turno',
            'Hora Salida Turno',
            'Horas Extras',
            'Minutos Extras'
        ]);
        return $datas;
    }
}
