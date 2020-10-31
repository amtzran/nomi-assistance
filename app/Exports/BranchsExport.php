<?php

namespace App\Exports;

use App\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;

/**
 * Class BranchsExport
 * @package App\Exports
 */
class BranchsExport implements FromCollection
{
    private $id_empresa;

    /**
     * BranchsExport constructor.
     * @param $id_empresa
     */
    public function __construct($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }

    public function collection()
    {
        return Branch::where('id_empresa', $this->id_empresa)->get();
    }
}
