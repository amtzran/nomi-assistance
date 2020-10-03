<?php

namespace App\Http\Controllers;

use App\Imports\EmployeesImport;
use App\Exports\EmployeesExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Employee;

class EmployeeController extends Controller
{
    public function index(){
        $employees = DB::table('empleados as e')
            ->join('sucursales as s','e.id_sucursal','s.id')
            ->select('e.id','e.clave','e.nss','s.nombre as sucursal','e.nombre', 'e.apellido_paterno', 'e.apellido_materno', 'e.turno')
            ->paginate(10);
        return view('employee')->with(['employees' => $employees]);
    }

    /**
     * Exporta los datos de la tabla Empleados a excel.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        $name = 'Empleados-';
        $csvExtension = '.csv';
        $date = Carbon::now(); 
        $date = $date->toFormattedDateString();
        $nameFecha = $name . $date . $csvExtension;
        return Excel::download(new EmployeesExport, $nameFecha);
    }

    /**
     * Importa datos desde un archivo excel a la tabla de Empleados.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import()
    {
        DB::table('empleados')->delete();

        Excel::import(new EmployeesImport, 'empleado.csv');

        return redirect('/')->with('success', 'All good!');
    }

    public function employeeFile(Request $request){
        Storage::putFileAs('/', $request->file('employee'), 'empleado.csv');
        $this->import();
        return redirect()->route('employees');
    }
}
