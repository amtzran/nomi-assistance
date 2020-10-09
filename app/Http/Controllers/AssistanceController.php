<?php

namespace App\Http\Controllers;

use App\Imports\AssistancesImport;
use App\Assistance;
use App\Employee;
use App\Exports\AssistancesExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AssistanceController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function assistance(){
        $assistance = DB::table('asistencia as a')
            ->join('empleados as e', 'a.id_clave', 'e.clave')
            ->join('ausencias as au', 'a.asistencia', 'au.id')
            ->select('e.clave', 'e.nss', 'e.nombre', 'e.apellido_paterno', 'au.nombre as nombre_incidencia',
                 'a.hora_entrada', 'a.hora_salida', 'a.fecha_entrada')
            ->paginate(10);
        return view('assistance')->with(['assistance' => $assistance]);
    }

    //
    public function getSucByJson(){
        $branches = DB::table('sucursales')->get();
        echo $branches->toJson();
    }

    // Esta es una prueba
    public function getEmployeesByJson(){
        $employees = DB::table('empleados')->get();
        echo $employees->toJson();
    }

    /**
     * Guarda la asistencia por la clave del empleado
     * @return JSON
     */
    public function saveAssistance(Request $request){

        try {
            
            $employeeKey = $request->get('key');
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
                    $assistance->save();
                }
            }

            return response()->json([
                'code' => 201,
                'message' => 'Registro guardado.'
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new AssistancesExport, 'asistencias.csv');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import()
    {
        DB::table('asistencia')->delete();

        Excel::import(new AssistancesImport, 'asistencia.csv');

        return redirect('/')->with('success', 'All good!');
    }

    public function assistanceFile(Request $request){
        Storage::putFileAs('/', $request->file('assistance'), 'asistencia.csv');
        $this->import();
        return redirect()->route('assistance');
    }

}
