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
            ->join('sucursales as s','e.id_sucursal','s.clave')
            ->select('e.id','e.clave','e.nss','s.nombre as sucursal','s.clave as sucursalId','e.nombre', 'e.apellido_paterno', 'e.apellido_materno', 'e.turno')
            ->paginate(10);
        $branches = DB::table('sucursales as s')->get();    
        return view('employee')->with(['employees' => $employees,'sucursales' => $branches]);
    }

    // Guardar Empleados
    public function create(Request $request){
        try {
            $requestKey = $request->clave;

            $isExist = Employee::where('clave', $requestKey)->first();
            if ($isExist) {
                return response()->json([
                    'code' => 500,
                    'message' => 'La clave del empleado ya existe.'
                ]);
            }

            $employee = new Employee;
            $employee->clave = $request->clave;
            $employee->nss = $request->nss;
            //Checar que dato se manda
            $employee->id_sucursal = $request->id_sucursal;
            $employee->nombre = $request->nombre;
            $employee->apellido_paterno = $request->apellido_paterno;
            $employee->apellido_materno = $request->apellido_materno;
            $employee->turno = $request->turno;
            $employee->id_empresa = 1;
    
            $employee->save();
            
            return response()->json([
                'code' => 201,
                'message' => 'Registro Guardado'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => 'Algo ha salido mal. intenta de nuevo.'
            ]);
        }
    }
    public function edit($id)
    {
        $employees = DB::table('empleados as e')
            ->join('sucursales as s','e.id_sucursal','s.clave')
            ->select('e.id','e.clave','e.nss','s.nombre as sucursal','e.nombre', 'e.apellido_paterno', 'e.apellido_materno', 'e.turno')
            ->where('e.id', $id)->first();

            $branches = DB::table('sucursales')->get();
            return view('employee')->with(['employees' => $employees,'sucursales' => $branches]);
    }
    //Update
    public function updateEmployee(Request $request){
        
        $employee = Employee::find($request->id);
        $employee->clave = $request->clave;
        $employee->nss = $request->nss;
        $employee->id_sucursal = $request->sucursal;
        $employee->nombre = $request->nombre;
        $employee->apellido_paterno = $request->apellido_paterno;
        $employee->apellido_materno = $request->apellido_materno;
        $employee->turno = $request->turno;
        $employee->id_empresa = 1;
        
        $employee->save();
        
        return redirect()->route('updateEmployee')->with('success', 'Datos Guardados Correctamente.');
    }
    //Delete
    public function deleteEmployee(Request $request){

        $employee = Employee::find($request->id);
        $employee->delete();

        return redirect()->route('employees')->with('success', 'Datos eliminados Correctamente.');

    }
    /**
     * Exporta los datos de la tabla Empleados a excel.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        $name = 'Empleados-';
        $csvExtension = '.xlsx';
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

        Excel::import(new EmployeesImport, 'empleado.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
    public function employeeFile(Request $request){
        Storage::putFileAs('/', $request->file('employee'), 'empleado.xlsx');
        $this->import();
        return redirect()->route('employees');
    }
}
