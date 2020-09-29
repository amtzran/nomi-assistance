<?php

namespace App\Exports;

use App\Assistance;
use Maatwebsite\Excel\Concerns\FromCollection;

class AssistancesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Assistance::all();
    }
}
