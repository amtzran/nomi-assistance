<?php

namespace App\Http\Controllers;

use App\Exports\AssistancesExport;
use App\Imports\AssistancesImport;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class AssistanceController
 * @package App\Http\Controllers
 */
class AssistanceController extends Controller
{
    /**
     * Return view welcome
     */
    public function index() {
        return view('welcome');
    }

    /**
     * Returns the assistance view with data.
     */
    public function assistance(Request $request) {
        // Filters
        $keyAssistance = $request->get('keyAssistance');
        $nssAssistance = $request->get('nssAssistance');
        $nameAssistance = $request->get('nameAssistance');
        $lastNameAssistance = $request->get('lastNameAssistance');
        $typeAssistance = $request->get('typeAssistance');
        $hourInAssistance = $request->get('hourInAssistance');
        $hourOutAssistance = $request->get('hourOutAssistance');
        $initialDate = $request->get('initialDate');
        if ($initialDate == null) $initialDate = 'null';
        $finalDate = $request->get('finalDate');
        if ($finalDate == null) $finalDate = 'null';

        $forPage = 10;
        if ($request->exists('forPage')) $forPage = $request->get('forPage');

        $assistance = DB::table('asistencia as a')
            ->join('empleados as e', 'a.id_clave', 'e.clave')
            ->join('ausencias as au', 'a.asistencia', 'au.id')
            ->select('e.clave', 'e.nss', 'e.nombre', 'e.apellido_paterno', 'au.nombre as nombre_incidencia',
                 'a.hora_entrada', 'a.hora_salida', 'a.fecha_entrada', 'a.geolocalizacion', 'e.id_empresa')
            ->where('e.id_empresa', auth()->user()->id_empresa);

        if ($keyAssistance != null) $assistance->where('e.clave', 'like', '%'. $keyAssistance .'%');
        if ($nssAssistance != null) $assistance->where('e.nss', 'like', '%'. $nssAssistance .'%');
        if ($nameAssistance != null) $assistance->where('e.nombre', 'like', '%'. $nameAssistance .'%');
        if ($lastNameAssistance != null) $assistance->where('e.apellido_paterno', 'like', '%'. $lastNameAssistance .'%');
        if ($typeAssistance != 0) $assistance->where('au.id', $typeAssistance);
        if ($hourInAssistance != null) {
            $hourIn = $hourInAssistance . ':00';
            $assistance->whereTime('a.hora_entrada', '>=', $hourIn);
        }
        if ($hourInAssistance != null) {
            $hourOut = $hourOutAssistance . ':00';
            $assistance->whereTime('a.hora_entrada', '<=', $hourOut);
        }
        if ($initialDate != 'null' && $finalDate != 'null') {
            $assistance->whereDate('a.fecha_entrada', '>=', $initialDate)
                ->whereDate('a.fecha_entrada', '<=', $finalDate);
        }

        $employees = DB::table('empleados as e')
            ->where('id_empresa', auth()->user()->id_empresa)
            ->orderBy('e.nombre')
            ->get();

        $assistances = $assistance->orderBy('a.created_at','DESC')->paginate($forPage)->appends([
            'keyAssistance' => $request->keyAssistance,
            'nssAssistance' => $request->nssAssistance,
            'nameAssistance' => $request->nameAssistance,
            'lastNameAssistance' => $request->lastNameAssistance,
            'typeAssistance' => $request->typeAssistance,
            'initialDate' => $request->initialDate,
            'finalDate' => $request->finalDate
        ]);

        //Filters
        $absences = DB::table('ausencias')->get();

        return view('assistance')->with([
            'assistance' => $assistances,
            'absences' => $absences,
            'employees' => $employees
        ]);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request)
    {
        $radioReport = $request->get("radioReport");
        $date_initial = $request->get("date_initial");
        $date_final = $request->get("date_final");
        $id_company = auth()->user()->id_empresa;
        $name = 'Asistencias-';
        $csvExtension = '.xlsx';
        $date = Carbon::now();
        $date = $date->toFormattedDateString();
        $nameFecha = $name . $date . $csvExtension;

        if ($radioReport === "today" ){
            return Excel::download(new AssistancesExport(1,null,null, $id_company), $nameFecha);
        }
        else if ($radioReport === "all" ){
            return Excel::download(new AssistancesExport(2,null,null, $id_company), $nameFecha);
        }
        return Excel::download(new AssistancesExport(3,$date_initial,$date_final, $id_company), $nameFecha);
    }

    /**
     *  Import data assistance's to excel
     */
    public function import() {
        DB::table('asistencia')->delete();

        Excel::import(new AssistancesImport, 'asistencia.xlsx');

        return redirect('/')->with('success', 'All good!');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function assistanceFile(Request $request) {
        Storage::putFileAs('/', $request->file('assistance'), 'asistencia.xlsx');
        $this->import();
        return redirect()->route('assistance');
    }

    public function ExportHourExtra(Request $request){
        try {
            $employee = $request->get('employee');
            $initialDateHour = $request->get('initialDateHour');
            $finalDateHour = $request->get('finalDateHour');

            $assistances = DB::table('asistencia as a')
                ->join('empleados as e', 'a.id_clave', 'e.clave')
                ->join('ausencias as au', 'a.asistencia', 'au.id')
                ->join('turnos as t','e.id_turno','t.id')
                ->select('e.clave', 'e.nss', 'e.nombre', 'e.apellido_paterno', 'au.nombre as nombre_incidencia',
                    'a.hora_entrada', 'a.hora_salida', 'a.fecha_entrada', 'a.geolocalizacion', 'e.id_empresa', 't.hora_salida as hora_salida_turno')
                ->where('e.id_empresa', auth()->user()->id_empresa)
                ->where('a.entrada' ,1)
                ->where('a.salida' ,1)
                ->whereDate("a.fecha_entrada", '>=', $initialDateHour)
                ->whereDate('a.fecha_entrada', '<=', $finalDateHour);

            if ($employee != 0) $assistances->where('e.id', $employee);

            $assistances = $assistances->get();

            $totalMinutes = 0;
            foreach ($assistances as $assistance) {
                $hoursOutEmployee = Carbon::parse($assistance->hora_salida);
                $hoursOutTurn = Carbon::parse($assistance->hora_salida_turno);
                $minutes = $hoursOutTurn->diffInMinutes($hoursOutEmployee);
                $totalMinutes += $minutes;
                $assistance->minutes = $minutes;
                $assistance->hours = intdiv($minutes, 60).':'. ($minutes % 60);
            }

            $totalHours = intdiv($totalMinutes, 60).':'. ($totalMinutes % 60);

            return response()->json([
                'code' => 200,
                'hours' => $totalHours,
                'minutes' => $totalMinutes,
                'assistances' => $assistances
            ]);
        } catch (\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => 'Algo salió Mal, Intenta de Nuevo'
            ]);
        }

    }

}
