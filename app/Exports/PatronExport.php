<?php

namespace App\Exports;

use App\Models\Patron;
use Maatwebsite\Excel\Concerns\FromCollection;

class PatronExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Patron::all();
    }
}
