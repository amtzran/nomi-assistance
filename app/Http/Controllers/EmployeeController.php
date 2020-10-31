<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Exports\EmployeesExport;
use App\Imports\EmployeesImport;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

/**
 * Class EmployeeController
 * @package App\Http\Controllers
 */
class EmployeeController extends Controller
{
    public function index() {
        $search = Input::get('search');
        $employees = DB::table('empleados as e')
            ->join('sucursales as s','e.id_sucursal','s.clave')
            ->join('turnos as t','e.id_turno','t.id')
            ->select('e.id','e.clave','e.nss','s.nombre as sucursal','s.clave as sucursalId','e.nombre',
                'e.apellido_paterno', 'e.apellido_materno', 't.nombre_turno as turno','t.id as turnoId')
            ->where('e.id_empresa', auth()->user()->id_empresa)->where(function ($query) use ($search) {
                $query->where('e.clave', 'like', '%'.$search.'%')
                ->orWhere('e.nss', 'like', '%'.$search.'%')
                ->orWhere('e.nombre', 'like', '%'.$search.'%')
                ->orWhere('e.apellido_paterno', 'like', '%'.$search.'%');
            })->paginate(10);

        $turns = DB::table('turnos as t')->where('id_empresa', auth()->user()->id_empresa)->get();
        $branches = DB::table('sucursales as s')->where('id_empresa', auth()->user()->id_empresa)->get();
        return view('employee')->with(['employees' => $employees,'sucursales' => $branches,'turnos' => $turns]);
    }

    /**
     * Guarda un nuevo empleado
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request){
        try {
            $requestKey = $request->get('clave');

            $isExist = Employee::where('clave', $requestKey)->first();
            if ($isExist) {
                return response()->json([
                    'code' => 500,
                    'message' => 'La clave del empleado ya existe.'
                ]);
            }

            $employee = new Employee;
            $employee->clave = $request->get('clave');
            $employee->nss = $request->get('nss');
            $employee->id_sucursal = $request->get('id_sucursal');
            $employee->nombre = $request->get('nombre');
            $employee->apellido_paterno = $request->get('apellido_paterno');
            $employee->apellido_materno = $request->get('apellido_materno');
            $employee->id_turno = $request->get('id_turno');
            $employee->id_empresa = auth()->user()->id_empresa;
            $employee->save();

            return response()->json([
                'code' => 201,
                'message' => 'Registro Guardado'
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => 'Algo ha salido mal. intenta de nuevo.'
            ]);
        }
    }

    /**
     * Vista para editar los empleados
     * @param $id
     * @return Factory|Application|View
     */
    public function edit($id)
    {
        $employees = DB::table('empleados as e')
            ->join('sucursales as s','e.id_sucursal','s.clave')
            ->select('e.id','e.clave','e.nss','s.nombre as sucursal','e.nombre', 'e.apellido_paterno',
                'e.apellido_materno', 'e.turno')
            ->where('e.id', $id)->first();

            $branches = DB::table('sucursales')->where('id_empresa', auth()->user()->id_empresa)->get();
            return view('employee')->with(['employees' => $employees,'sucursales' => $branches]);
    }


    /**
     * Actualiza un empleado por su id.
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateEmployee(Request $request){

        $employee = Employee::find($request->get('id'));
        $employee->clave = $request->get('clave');
        $employee->nss = $request->get('nss');
        $employee->id_sucursal = $request->get('sucursal');
        $employee->nombre = $request->get('nombre');
        $employee->apellido_paterno = $request->get('apellido_paterno');
        $employee->apellido_materno = $request->get('apellido_materno');
        $employee->id_turno = $request->get('turno');
        $employee->id_empresa = auth()->user()->id_empresa;
        $employee->save();

        return redirect()->route('employees')->with('success', 'Datos Guardados Correctamente.');
    }

    /**
     * Elimina un empleado por su id.
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteEmployee(Request $request){

        $employee = Employee::find($request->get('id'));
        $employee->delete();

        return redirect()->route('employees')->with('success', 'Datos eliminados Correctamente.');

    }

    /**
     * Exporta los datos de la tabla Empleados a excel.
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export()
    {
        $name = 'Empleados-';
        $csvExtension = '.xlsx';
        $date = Carbon::now();
        $date = $date->toFormattedDateString();
        $nameFecha = $name . $date . $csvExtension;
        return Excel::download(new EmployeesExport(auth()->user()->id_empresa), $nameFecha);
    }

    /**
     * Importa datos desde un archivo excel a la tabla de Empleados.
     * @return RedirectResponse
     */
    public function import()
    {
        DB::table('empleados')->delete();

        Excel::import(new EmployeesImport(auth()->user()->id_empresa), 'empleado.xlsx');

        return redirect('/')->with('success', 'Empleados cargados correctamente!');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function employeeFile(Request $request){
        Storage::putFileAs('/', $request->file('employee'), 'empleado.xlsx');
        $this->import();
        return redirect()->route('employees');
    }
}
