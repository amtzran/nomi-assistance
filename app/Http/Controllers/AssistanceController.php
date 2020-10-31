<?php

namespace App\Http\Controllers;

use App\Assistance;
use App\Employee;
use App\Exports\AssistancesExport;
use App\Imports\AssistancesImport;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

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
    public function assistance() {
        $assistance = DB::table('asistencia as a')
            ->join('empleados as e', 'a.id_clave', 'e.clave')
            ->join('ausencias as au', 'a.asistencia', 'au.id')
            ->select('e.clave', 'e.nss', 'e.nombre', 'e.apellido_paterno', 'au.nombre as nombre_incidencia',
                 'a.hora_entrada', 'a.hora_salida', 'a.fecha_entrada', 'a.geolocalizacion', 'e.id_empresa')
            ->where('e.id_empresa', auth()->user()->id_empresa)
            ->paginate(10);

        return view('assistance')->with(['assistance' => $assistance]);
    }

    /**
     * Get all branches
     */
    public function getSucByJson() {
        $branches = DB::table('sucursales')->get();
        echo $branches->toJson();
    }

    /**
     * Get all employees
     */
    public function getEmployeesByJson() {
        $employees = DB::table('empleados as e')
            ->join('turnos as t', 'e.id_turno', 't.id')
            ->select('e.*', 't.nombre_turno as turno')
            ->get();

        echo $employees->toJson();
    }

    /**
     * Save assistance of employee
     * @param Request $request
     * @return JsonResponse
     */
    public function saveAssistance(Request $request) {

        try {

            $employeeKey = $request->get('key');
            $coordinates = $request->get('coordinates');
            $employee = Employee::where('clave', $employeeKey)->first();

            if ($employee){

                $entry = Assistance::where('id_clave', $employee->clave)
                    ->where('fecha_entrada', Carbon::now()->toDateString())
                    ->where('entrada', 1)
                    ->first();

                $complete = Assistance::where('id_clave', $employee->clave)
                    ->where('fecha_entrada', Carbon::now()->toDateString())
                    ->where('fecha_salida', Carbon::now()->toDateString())
                    ->where('entrada', 1)
                    ->where('salida', 1)
                    ->first();

                if ($complete) {
                    return response()->json([
                        'code' => 200,
                        'message' => 'El empleado ya cuenta con asistencia.'
                    ], 201);
                }

                if ($entry) {
                    $assistance = Assistance::find($entry->id);
                    $assistance->asistencia = 1;
                    $assistance->salida = 1;
                    $assistance->hora_salida = Carbon::now()->toTimeString();
                    $assistance->fecha_salida = Carbon::now()->toDateString();
                    $assistance->save();
                } else {
                    $assistance = new Assistance;
                    $assistance->id_clave = $employee->clave;
                    $assistance->asistencia = 2;
                    $assistance->entrada = 1;
                    $assistance->salida = 0;
                    $assistance->hora_entrada = Carbon::now()->toTimeString();
                    $assistance->fecha_entrada = Carbon::now()->toDateString();
                    $assistance->geolocalizacion = $coordinates;
                    $assistance->save();
                }
            }

            return response()->json([
                'code' => 201,
                'message' => 'Registro guardado.'
            ], 201);

        } catch (Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
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
        $date_initial =$request->get("date_initial");
        $date_final =$request->get("date_final");
        $name = 'Asistencias-';
        $csvExtension = '.xlsx';
        $date = Carbon::now();
        $date = $date->toFormattedDateString();
        $nameFecha = $name . $date . $csvExtension;

        if ($radioReport === "today" ){
            return Excel::download(new AssistancesExport(1,null,null), $nameFecha);
        }
        else if ($radioReport === "all" ){
            return Excel::download(new AssistancesExport(2,null,null), $nameFecha);
        }
        return view('assistance')->Excel::download(new AssistancesExport(3,$date_initial,$date_final), $nameFecha);
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

}
