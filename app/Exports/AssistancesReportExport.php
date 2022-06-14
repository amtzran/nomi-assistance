<?php

namespace App\Exports;

use App\Employee;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssistancesReportExport implements FromCollection, WithStyles
{

    private $initial_date;
    private $final_date;
    private $id_employee;

    /**
     * AssistancesReportExport constructor.
     * @param $initial_date
     * @param $final_date
     * @param $id_employee
     */
    public function __construct($initial_date, $final_date, $id_employee)
    {
        $this->initial_date = $initial_date;
        $this->final_date = $final_date;
        $this->id_employee = $id_employee;
    }

    /**
     * Exporta una colección de asistencias a excel.
     * @return Collection
     */
    public function collection()
    {
        $assistances = DB::table('asistencia as a')
            ->join('empleados as e', 'a.id_clave', 'e.clave')
            ->join('ausencias as au', 'a.asistencia', 'au.id')
            ->join('turnos as t','e.id_turno','t.id')
            ->select('a.*', 't.hora_entrada as hora_entrada_turno', 't.hora_salida as hora_salida_turno')
            ->where('e.id_empresa', auth()->user()->id_empresa)
            ->where('e.id', $this->id_employee)
            ->whereDate("a.fecha_entrada", '>=', $this->initial_date)
            ->whereDate('a.fecha_entrada', '<=', $this->final_date)
            ->orderBy('a.fecha_entrada');

        $employee = Employee::findOrFail($this->id_employee);

        $diasTrabajados = 0;
        $diasDescanso = 0;
        $retardos = 0;
        $faltas = 0;
        $horasTrabajadas = 0;
        $minutosExtras = 0;

        $datas = $assistances->get();
        $report = new \Illuminate\Database\Eloquent\Collection();

        $period = CarbonPeriod::create($this->initial_date, $this->final_date);
        foreach ($period as $date) {
            if ($date->isSunday()) $diasDescanso += 1;
        }

        foreach ($datas as $assistance) {
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

            $isGreat = $hoursOutEmployee->gt($hoursOutTurn);
            if (!$isGreat && $assistance->hora_salida != null) {
                $minutes = $hoursOutEmployee->diffInMinutes($hoursOutTurn);
                $assistance->minutes = $minutes * -1;
                $minutes = $minutes * -1;
            }

            $isGreatInit = $hoursInEmployee->gt($hoursInTurn);
            if (!$isGreatInit) {
                $minutesIn = $hoursInEmployee->diffInMinutes($hoursInTurn);
                $minutes = $minutes + $minutesIn;
                $assistance->minutes = $minutes;
            }

            if ($assistance->hora_salida == null) {
                $minutes = 0;
                $assistance->minutes = $minutes;
            }


            // Totals
            $workHours = $hoursOutEmployee->diffInHours($hoursInEmployee);
            $horasTrabajadas += $workHours;
            if (!$dateStart->isSunday()) $diasTrabajados += 1;

            $minutosTarde = $hoursInTurn->diffInMinutes($hoursInEmployee);
            if ($minutosTarde >= 5) $retardos += 1;

            if ($assistance->salida == 0) $faltas += 1;
            if (!$dateStart->isSaturday()) $horasTrabajadas -= 1;
            
            if ($isGreatInit) {
                $minutes = $minutes - $minutosTarde;
                $assistance->minutes = $minutes;
            }

            $minutosExtras += $minutes;
            
            $report->push([
                'fecha_entrada' => $assistance->fecha_entrada,
                'dia' => $assistance->day,
                'hora_entrada' => $assistance->hora_entrada,
                'hora_salida' => $assistance->hora_salida,
                'extra_minutes' => $assistance->minutes
            ]);
        }

        $report->prepend([
            'FECHA',
            'DIA',
            'ENTRADA',
            'SALIDA',
            'MINUTOS'
        ]);
        $report->prepend([
            '',
            '',
            '',
            '',
            ''
        ]);
        $report->prepend([
            'NOMBRE:',
            $employee->nombre . ' ' . $employee->apellido_paterno . ' ' . $employee->apellido_materno
        ]);

        $report->push([
            '',
            '',
            '',
            '',
            ''
        ]);

        $report->push([
            'DIAS TRABAJADOS:',
            '',
            $diasTrabajados,
            '',
            ''
        ]);

        $report->push([
            'DIAS DESCANSO',
            '',
            $diasDescanso,
            '',
            ''
        ]);

        $report->push([
            'RETARDOS',
            '',
            $retardos,
            '',
            ''
        ]);

        $report->push([
            'FALTAS',
            '',
            $faltas,
            '',
            ''
        ]);

        $report->push([
            'HORAS TRABAJADAS',
            '',
            $horasTrabajadas,
            '',
            ''
        ]);

        $report->push([
            'TOTAL EXTRAS',
            '',
            $minutosExtras,
            '',
            ''
        ]);

        return $report;

    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            3    => ['font' => ['bold' => true]],
        ];
    }
}
