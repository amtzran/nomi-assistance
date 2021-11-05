<?php

namespace App\Http\Controllers;

use App\Exports\AssistancesExport;
use App\Imports\AssistancesImport;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class AssistanceController
 * @package App\Http\Controllers
 */
class AssistanceController extends Controller
{
    /**
     * Return view welcome
     */
    public function index() {
        return view('welcome');
    }

    /**
     * Returns the assistance view with data.
     */
    public function assistance(Request $request) {
        // Filters
        $keyAssistance = $request->get('keyAssistance');
        $nssAssistance = $request->get('nssAssistance');
        $nameAssistance = $request->get('nameAssistance');
        $lastNameAssistance = $request->get('lastNameAssistance');
        $typeAssistance = $request->get('typeAssistance');
        $hourInAssistance = $request->get('hourInAssistance');
        $hourOutAssistance = $request->get('hourOutAssistance');
        $initialDate = $request->get('initialDate');
        if ($initialDate == null) $initialDate = 'null';
        $finalDate = $request->get('finalDate');
        if ($finalDate == null) $finalDate = 'null';

        $forPage = 10;
        if ($request->exists('forPage')) $forPage = $request->get('forPage');

        $assistance = DB::table('asistencia as a')
            ->join('empleados as e', 'a.id_clave', 'e.clave')
            ->join('ausencias as au', 'a.asistencia', 'au.id')
            ->select('e.clave', 'e.nss', 'e.nombre', 'e.apellido_paterno', 'au.nombre as nombre_incidencia',
                 'a.hora_entrada', 'a.hora_salida', 'a.fecha_entrada', 'a.geolocalizacion', 'e.id_empresa')
            ->where('e.id_empresa', auth()->user()->id_empresa);

        if ($keyAssistance != null) $assistance->where('e.clave', 'like', '%'. $keyAssistance .'%');
        if ($nssAssistance != null) $assistance->where('e.nss', 'like', '%'. $nssAssistance .'%');
        if ($nameAssistance != null) $assistance->where('e.nombre', 'like', '%'. $nameAssistance .'%');
        if ($lastNameAssistance != null) $assistance->where('e.apellido_paterno', 'like', '%'. $lastNameAssistance .'%');
        if ($typeAssistance != 0) $assistance->where('au.id', $typeAssistance);
        if ($hourInAssistance != null) {
            $hourIn = $hourInAssistance . ':00';
            $assistance->whereTime('a.hora_entrada', '>=', $hourIn);
        }
        if ($hourInAssistance != null) {
            $hourOut = $hourOutAssistance . ':00';
            $assistance->whereTime('a.hora_entrada', '<=', $hourOut);
        }
        if ($initialDate != 'null' && $finalDate != 'null') {
            $assistance->whereDate('a.fecha_entrada', '>=', $initialDate)
                ->whereDate('a.fecha_entrada', '<=', $finalDate);
        }

        $assistances = $assistance->orderBy('a.created_at','DESC')->paginate($forPage)->appends([
            'keyAssistance' => $request->keyAssistance,
            'nssAssistance' => $request->nssAssistance,
            'nameAssistance' => $request->nameAssistance,
            'lastNameAssistance' => $request->lastNameAssistance,
            'typeAssistance' => $request->typeAssistance,
            'initialDate' => $request->initialDate,
            'finalDate' => $request->finalDate
        ]);

        //Filters
        $absences = DB::table('ausencias')->get();

        return view('assistance')->with([
            'assistance' => $assistances,
            'absences' => $absences
        ]);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request)
    {
        $radioReport = $request->get("radioReport");
        $date_initial = $request->get("date_initial");
        $date_final = $request->get("date_final");
        $id_company = auth()->user()->id_empresa;
        $name = 'Asistencias-';
        $csvExtension = '.xlsx';
        $date = Carbon::now();
        $date = $date->toFormattedDateString();
        $nameFecha = $name . $date . $csvExtension;

        if ($radioReport === "today" ){
            return Excel::download(new AssistancesExport(1,null,null, $id_company), $nameFecha);
        }
        else if ($radioReport === "all" ){
            return Excel::download(new AssistancesExport(2,null,null, $id_company), $nameFecha);
        }
        return Excel::download(new AssistancesExport(3,$date_initial,$date_final, $id_company), $nameFecha);
    }

    /**
     *  Import data assistance's to excel
     */
    public function import() {
        DB::table('asistencia')->delete();

        Excel::import(new AssistancesImport, 'asistencia.xlsx');

        return redirect('/')->with('success', 'All good!');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function assistanceFile(Request $request) {
        Storage::putFileAs('/', $request->file('assistance'), 'asistencia.xlsx');
        $this->import();
        return redirect()->route('assistance');
    }

}
