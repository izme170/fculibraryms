<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MonthlyLoginStatisticsExport implements FromView
{
    protected $reportData;
    protected $rowTotals;
    protected $monthlyTotals;
    protected $grandTotal;
    protected $year;

    public function __construct($reportData, $rowTotals, $monthlyTotals, $grandTotal, $year)
    {
        $this->reportData = $reportData;
        $this->rowTotals = $rowTotals;
        $this->monthlyTotals = $monthlyTotals;
        $this->grandTotal = $grandTotal;
        $this->year = $year;
    }

    public function view(): View
    {
        return view('exports.monthly_login_statistics', [
            'reportData' => $this->reportData,
            'rowTotals' => $this->rowTotals,
            'monthlyTotals' => $this->monthlyTotals,
            'grandTotal' => $this->grandTotal,
            'year' => $this->year,
        ]);
    }
}