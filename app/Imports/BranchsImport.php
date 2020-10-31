<?php

namespace App\Imports;

use App\Branch;
use Maatwebsite\Excel\Concerns\ToModel;

/**
 * Class BranchsImport
 * @package App\Imports
 */
class BranchsImport implements ToModel
{
    private $id_empresa;

    /**
     * BranchsImport constructor.
     * @param $id_empresa
     */
    public function __construct($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }


    /**
     * @param array $row
     * @return Branch
     */
    public function model(array $row)
    {
        return new Branch([
            'clave' => $row[0],
            'nombre' => $row[1],
            'id_empresa' => $this->id_empresa
        ]);
    }
}
