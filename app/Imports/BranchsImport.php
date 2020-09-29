<?php

namespace App\Imports;

use App\Branch;
use Maatwebsite\Excel\Concerns\ToModel;

class BranchsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Branch([
            'clave' => $row[0],
            'nombre' => $row[1],
        ]);
    }
}
