<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Turn;

class ConfigurationController extends Controller
{
    //
    public function index(){
        $turns = DB::table('turnos')->paginate(10);
        return view('configuration')->with(['turns' => $turns]);
    }
    // Guardar Turnos
    public function create(Request $request){
        try {

            $turn = new Turn;
            $turn->nombre_turno= $request->nombre_turno;
            $turn->hora_entrada= $request->hora_entrada;
            $turn->hora_salida= $request->hora_salida;
            $turn->id_empresa= 0;

            $turn->save();

            return response()->json([
                'code' => 201,
                'message' => 'Registro Guardado'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => $th
            ]);
        }
    }
    // Actualizar Turnos
    public function updateTurn(Request $request){

        $turn = Turn::find($request->id);
        $turn->nombre_turno = $request->nombre_turno;
        $turn->hora_entrada = $request->hora_entrada;
        $turn->hora_salida = $request->hora_salida;
        $turn->id_empresa = 0;

        $turn->save();

        return redirect()->route('configuration')->with('success', 'Datos Guardados Correctamente.');
    }
    //Eliminar Turnos
    public function deleteTurn(Request $request){

        $turn = Turn::find($request->id);
        $turn->delete();

        return redirect()->route('configuration')->with('success', 'Datos eliminados Correctamente.');

    }
}
