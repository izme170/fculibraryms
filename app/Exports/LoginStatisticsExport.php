<?php

namespace App\Exports;

use App\Models\PatronLogin;
use Maatwebsite\Excel\Concerns\FromCollection;

class LoginStatisticsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PatronLogin::all();
    }
}
