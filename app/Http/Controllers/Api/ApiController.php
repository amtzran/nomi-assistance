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
     * Get all branchs by company to JSON
     * @param $empresaId
     * @return JsonResponse
     */
    public function getSucByJson($empresaId) {
        $branches = DB::table('sucursales')
            ->where('id_empresa', $empresaId)
            ->get();
        return response()->json($branches);
    }

    /**
     * Get all employees by company to JSON
     * @param $empresaId
     * @return JsonResponse
     */
    public function getEmployeesByJson($empresaId) {
        $employees = DB::table('empleados as e')
            ->join('turnos as t', 'e.id_turno', 't.id')
            ->select('e.*', 't.nombre_turno as turno')
            ->where('e.id_empresa', $empresaId)
            ->orderBy('e.clave', 'asc')
            ->get();

        $date = Carbon::now();
        $date = $date->toDateString();

        foreach ($employees as $employee) {
            $employees->map(function ($employee) use ($date) {
                $isAssistance = Assistance::where('fecha_entrada', $date)
                    ->where('id_clave', $employee->clave)->first();
                if ($isAssistance) {
                    if ($isAssistance->entrada == 1 && $isAssistance->salida == 1) $employee->color = "#138D75";
                    if ($isAssistance->entrada == 1 && $isAssistance->salida == 0) $employee->color = "#F39C12";
                } else $employee->color = "#1F618D";
            });
        }

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
            if (!$this->validateCredentials($employeeKey, $pin)) {
                return response()->json([
                    'code' => 401,
                    'message' => 'El PIN es incorrecto.'
                ], 200);
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
        if ($nip == $pin) return true;
        return false;
    }
}
