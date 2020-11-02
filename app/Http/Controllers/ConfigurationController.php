<?php

namespace App\Http\Controllers;

use App\Turn;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;
use Validator;

/**
 * Class ConfigurationController
 * @package App\Http\Controllers
 */
class ConfigurationController extends Controller
{

    /**
     * @return Factory|Application|View
     */
    public function index(){
        $turns = DB::table('turnos')
            ->where('id_empresa', auth()->user()->id_empresa)
            ->paginate(10);
        return view('configuration')->with(['turns' => $turns]);
    }

    /**
     * Guarda un nuevo turno
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request){
        try {

            $turn = new Turn;
            $turn->nombre_turno= $request->get('nombre_turno');
            $turn->hora_entrada= $request->get('hora_entrada');
            $turn->hora_salida= $request->get('hora_salida');
            $turn->id_empresa= auth()->user()->id_empresa;

            $turn->save();

            return response()->json([
                'code' => 201,
                'message' => 'Registro Guardado'
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => $th
            ]);
        }
    }

    /**
     * Actualiza un turno por su id.
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateTurn(Request $request){

        $rules = [
            'nombre_turno' => 'required|max:255',
            'hora_entrada' => 'required',
            'hora_salida' => 'required'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->route('configuration')->withErrors($validator->messages())->withInput();
        }

        $turn = Turn::find($request->get('id'));
        $turn->nombre_turno = $request->get('nombre_turno');
        $turn->hora_entrada = $request->get('hora_entrada');
        $turn->hora_salida = $request->get('hora_salida');
        $turn->id_empresa = auth()->user()->id_empresa;

        $turn->save();

        return redirect()->route('configuration')->with('success', 'Datos Guardados Correctamente.');
    }

    /**
     * Elimina un turno por su id.
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteTurn(Request $request){

        $turn = Turn::find($request->get('id'));
        $turn->delete();

        return redirect()->route('configuration')->with('success', 'Datos eliminados Correctamente.');

    }
}
