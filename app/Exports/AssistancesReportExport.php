<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class AssistancesReportExport implements FromCollection
{

    private $initial_date;
    private $final_date;
    private $id_employee;

    public function __construct($initial_date, $final_date, $id_employee)
    {
        $this->initial_date = $initial_date;
        $this->final_date = $final_date;
        $this->id_employee = $id_employee;
    }

    public function collection()
    {
        $assistances = DB::table('asistencia as a')
            ->join('empleados as e', 'a.id_clave', 'e.clave')
            ->join('ausencias as au', 'a.asistencia', 'au.id')
            ->join('turnos as t','e.id_turno','t.id')
            ->select('a.*', 't.hora_entrada as hora_entrada_turno', 't.hora_salida as hora_salida_turno')
            ->where('e.id_empresa', auth()->user()->id_empresa)
            ->where('e.clave', 1)
            ->whereDate("a.fecha_entrada", '>=', $this->initialDateHour)
            ->whereDate('a.fecha_entrada', '<=', $this->finalDateHour);

        $diasTrabajados = 0;
        $diasDescanso = 0;
        $retardos = 0;
        $faltas = 0;
        $horasTrabajadas = 0;
        $minutosExtras = 0;

        $datas = $assistances->get();

        foreach ($assistances as $assistance) {
            $dateStart = Carbon::parse($assistance->fecha_entrada);
            if ($dateStart->isMonday()) $assistance->day = 'LUNES';
            if ($dateStart->isTuesday()) $assistance->day = 'MARTES';
            if ($dateStart->isWednesday()) $assistance->day = 'MIÉRCOLES';
            if ($dateStart->isThursday()) $assistance->day = 'JUEVES';
            if ($dateStart->isFriday()) $assistance->day = 'VIERNES';
            if ($dateStart->isSaturday()) $assistance->day = 'SÁBADO';
            if ($dateStart->isSunday()) $assistance->day = 'DOMINGO';

            // Calculate minutes extras
            $hoursInEmployee = Carbon::parse($assistance->hora_entrada);
            $hoursOutEmployee = Carbon::parse($assistance->hora_salida);
            $hoursOutTurn = Carbon::parse($assistance->hora_salida_turno);
            $hoursInTurn = Carbon::parse($assistance->hora_entrada_turno);
            if ($dateStart->isSaturday()) $hoursOutTurn = Carbon::parse('13:00:00');
            $minutes = $hoursOutTurn->diffInMinutes($hoursOutEmployee);
            $assistance->minutes = $minutes;
            $assistance->hours = intdiv($minutes, 60).':'. ($minutes % 60);

            // Totals
            $minutosExtras += $minutes;
            if (!$dateStart->isSunday()) $diasTrabajados += 1;
            if ($dateStart->isSunday()) $diasDescanso += 1;
            $minutosTarde = $hoursInTurn->diffInMinutes($hoursInEmployee);
            if ($minutosTarde >= 5) $retardos += 1;
            if ($assistance->salida == 0) $faltas += 1;
        }

        $datas->prepend([
            'FECHA',
            'DIA',
            'ENTRADA',
            'SALIDA',
            'EXTRAS',
        ]);
        return $datas;

    }
}