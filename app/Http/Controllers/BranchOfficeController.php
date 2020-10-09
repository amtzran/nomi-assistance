<?php

namespace App\Http\Controllers;

use App\Imports\BranchsImport;
use App\Exports\BranchsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Branch;

class BranchOfficeController extends Controller
{
    public function index(){
        $branch = DB::table('sucursales')->paginate(10);
        return view('branch')->with(['branch' => $branch]);
    }
    public function create(Request $request){
        try {
            $requestBranch = $request->clave;

            $isExist = Branch::where('clave', $requestBranch)->first;
            if($isExist) {
                return response()->json([
                    'code' => 500,
                    'message' => 'La clave de la sucursal ya existe.'
                ]);
            }

            $branch = new Branch;
            $branch->clave = $requestBranch;

            $branch->nombre = $request->nombre;
    
            $branch->save();
            
            return response()->json([
                'code' => 201,
                'message' => 'Registro Guardado'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => 'Algo ha salido mal, intenta de nuevo.'
            ]);
        }
    }
     //Update Sucursal
     public function updateBranch(Request $request){

        $requestBranch = $request->clave;
        
        $branch = Branch::find($request->id);
        $branch->clave = $requestBranch;
        $branch->nombre = $request->nombre;
        
        $branch->save();
        
        return redirect()->route('branch')->with('success', 'Datos Guardados Correctamente.');
    }
      //Delete Sucursal
      public function deleteBranch(Request $request){

        $branch = Branch::find($request->id);
        $branch->delete();

        return redirect()->route('branch')->with('success', 'Datos eliminados Correctamente.');

    }
    /**
     * Exporta los datos de la tabla Sucursales a excel.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new BranchsExport, 'sucursales.xlsx');
    }

    /**
     * Importa datos desde un archivo excel a la tabla de sucursales.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import()
    {
        DB::table('sucursales')->delete();

        Excel::import(new BranchsImport, 'sucursal.xlsx');

        return redirect('/')->with('success', 'All good!');
    }

    public function branchFile(Request $request){
        Storage::putFileAs('/', $request->file('branch'), 'sucursal.xlsx');
        $this->import();
        return redirect()->route('branch');
    }
}
