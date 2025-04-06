<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LoginStatisticsExport implements FromView
{
    protected $reportData;
    protected $rowTotals;
    protected $dailyTotals;
    protected $grandTotal;
    protected $year;
    protected $month;
    protected $daysInMonth;

    public function __construct($reportData, $rowTotals, $dailyTotals, $grandTotal, $year, $month, $daysInMonth)
    {
        $this->reportData = $reportData;
        $this->rowTotals = $rowTotals;
        $this->dailyTotals = $dailyTotals;
        $this->grandTotal = $grandTotal;
        $this->year = $year;
        $this->month = $month;
        $this->daysInMonth = $daysInMonth;
    }

    public function view(): View
    {
        return view('exports.login_statistics', [
            'reportData' => $this->reportData,
            'rowTotals' => $this->rowTotals,
            'dailyTotals' => $this->dailyTotals,
            'grandTotal' => $this->grandTotal,
            'year' => $this->year,
            'month' => $this->month,
            'daysInMonth' => $this->daysInMonth,
        ]);
    }
}