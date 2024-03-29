<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Exports\BranchsExport;
use App\Imports\BranchsImport;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;
use Validator;

/**
 * Class BranchOfficeController
 * @package App\Http\Controllers
 */
class BranchOfficeController extends Controller
{
    /**
     * Returns the branch view with data.
     */
    public function index() {
        $branch = DB::table('sucursales')
            ->where('id_empresa', auth()->user()->id_empresa)
            ->paginate(10);

        return view('branch')->with(['branch' => $branch]);
    }

    /**
     * Create a new branch
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) {
        try {
            $requestBranch = $request->get('clave');
            $idCompany = auth()->user()->id_empresa;

            $isExist = Branch::where('clave', $requestBranch)
                ->where('id_empresa', $idCompany)
                ->first();

            if($isExist) {
                return response()->json([
                    'code' => 500,
                    'message' => 'La clave de la sucursal ya existe.'
                ]);
            }

            $branch = new Branch;
            $branch->clave = $requestBranch;
            $branch->nombre = $request->get('nombre');
            $branch->id_empresa = auth()->user()->id_empresa;
            $branch->save();

            return response()->json([
                'code' => 201,
                'message' => 'Registro Guardado'
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => 'Algo ha salido mal, intenta de nuevo.'
            ]);
        }
    }

    /**
     * Update a branch
     * @param Request $request
     * @return RedirectResponse
     */
     public function updateBranch(Request $request) {

         $rules = [
             'nombre' => 'required|max:250',
         ];
         $data = $request->all();
         $validator = Validator::make($data, $rules);

         if ($validator->fails()) {
             return redirect()->route('branch')->withErrors($validator->messages())->withInput();
         }

        $branch = Branch::find($request->get('id'));
        $branch->nombre = $request->get('nombre');
        $branch->save();

        return redirect()->route('branch')->with('success', 'Datos Guardados Correctamente.');
    }

    /**
     * Delete a branch by id
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteBranch(Request $request) {

        $branch = Branch::find($request->get('id'));
        $branch->delete();

        return redirect()->route('branch')->with('success', 'Datos eliminados Correctamente.');

    }

    /**
     * Exporta los datos de la tabla Sucursales a excel.
     */
    public function export() {

        try {
            $name = 'Sucursales-';
            $csvExtension = '.xlsx';
            $date = Carbon::now();
            $date = $date->toFormattedDateString();
            $nameDate = $name . $date . $csvExtension;
            return Excel::download(new BranchsExport(auth()->user()->id_empresa), $nameDate);
        } catch (Exception $exception) {
            return redirect('/');
        }

    }

    /**
     * Importa datos desde un archivo excel a la tabla de sucursales.
     * @return RedirectResponse
     */
    public function import() {

        DB::table('sucursales')->where("id_empresa",auth()->user()->id_empresa)->delete();

        Excel::import(new BranchsImport(auth()->user()->id_empresa), 'sucursal.xlsx');

        return redirect('/')->with('success', 'Carga de Sucursales exitosa');

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function branchFile(Request $request) {
        Storage::putFileAs('/', $request->file('branch'), 'sucursal.xlsx');
        $this->import();
        return redirect()->route('branch');
    }
}
