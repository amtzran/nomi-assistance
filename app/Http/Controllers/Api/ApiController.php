<?php

namespace App\Http\Controllers\Api;

use App\Assistance;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Throwable;

class ApiController extends Controller
{
    /**
     * Get all branchs to JSON
     * @return JsonResponse
     */
    public function getSucByJson() {
        $branches = DB::table('sucursales')->get();
        return response()->json($branches);
    }

    /**
     * Get all employees to JSON
     * @return JsonResponse
     */
    public function getEmployeesByJson() {
        $employees = DB::table('empleados as e')
            ->join('turnos as t', 'e.id_turno', 't.id')
            ->select('e.*', 't.nombre_turno as turno')
            ->get();

        return response()->json($employees);
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
            $pin = $request->get('pin');

            if ($this->validateCredentials($employeeKey, $pin)) {
                return response()->json([
                    'code' => 201,
                    'message' => 'El PIN es incorrecto.'
                ], 401);
            }

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
     * Valida las credenciales de un empleado.
     * @param $employeeId
     * @param $pin
     * @return bool
     */
    public function validateCredentials($employeeId, $pin) {
        $nip = DB::table('autenticaciones')
            ->where('clave_empleado', $employeeId)
            ->first()->nip;
        if ($nip === $pin) return true;
        return false;
    }
}
