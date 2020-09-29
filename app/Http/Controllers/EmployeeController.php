<?php

namespace App\Http\Controllers;

use App\Imports\EmployeesImport;
use App\Exports\EmployeesExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(){
        $employees = DB::table('empleados')->paginate(10);
        return view('employee')->with(['employees' => $employees]);
    }

    /**
     * Exporta los datos de la tabla Empleados a excel.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new EmployeesExport, 'empleados.csv');
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
