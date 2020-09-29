<?php

namespace App\Http\Controllers;

use App\Imports\BranchsImport;
use App\Exports\BranchsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BranchOfficeController extends Controller
{
    public function index(){
        $branch = DB::table('sucursales')->paginate(10);
        return view('branch')->with(['branch' => $branch]);
    }

    /**
     * Exporta los datos de la tabla Sucursales a excel.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new BranchsExport, 'sucursales.csv');
    }

    /**
     * Importa datos desde un archivo excel a la tabla de sucursales.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import()
    {
        DB::table('sucursales')->delete();

        Excel::import(new BranchsImport, 'sucursal.csv');

        return redirect('/')->with('success', 'All good!');
    }

    public function branchFile(Request $request){
        Storage::putFileAs('/', $request->file('branch'), 'sucursal.csv');
        $this->import();
        return redirect()->route('branch');
    }
}
