<?php

namespace App\Http\Controllers;

use App\Imports\AssistancesImport;
use App\Assistance;
use App\Exports\AssistancesExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssistanceController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function assistance(){
        $assistance = DB::table('asistencia')->paginate(10);
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
     * Hola esta es una prueba
     * @version 10.1
     */
    public function saveAssistancesyJson(){
        $objString = file_get_contents('php://input');
        if (isset($objString))
        {
            $request = json_decode($objString);

            foreach($request as $employee) {
                $assistance = new Assistance;
                $assistance->id_empleado = $employee->id;
                $assistance->asistencia = $employee->assistance;
                $assistance->save();
            }
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
