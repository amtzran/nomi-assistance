<?php

namespace App\Exports;

use App\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;

class BranchsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Branch::all();
    }
}
