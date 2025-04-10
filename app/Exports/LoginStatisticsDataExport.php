<?php

namespace App\Exports;

use App\Models\PatronLogin;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LoginStatisticsDataExport implements FromView
{
    protected $year;
    protected $month;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function view(): View
    {
        $patron_logins = PatronLogin::with(['patron.type', 'patron.department', 'purpose', 'marketer'])
            ->whereYear('login_at', $this->year)
            ->whereMonth('login_at', $this->month)
            ->orderBy('login_at')
            ->get();

        return view('exports.login_statistics_data', compact('patron_logins'));
    }
}
