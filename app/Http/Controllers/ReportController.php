<?php

namespace App\Http\Controllers;

use App\Models\Patron;
use App\Models\PatronLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;

        // Top 10 patrons by login count
        $topPatrons = PatronLogin::whereMonth('login_at', $currentMonth)->join('patrons', 'patron_logins.patron_id', '=', 'patrons.patron_id')
            ->selectRaw('first_name, last_name, COUNT(login_id) as logins')
            ->groupBy('patron_logins.patron_id', 'first_name', 'last_name')
            ->orderByDesc('logins')
            ->limit(10)
            ->get();

        // Top 10 marketers by patron logins
        $topMarketers = PatronLogin::whereMonth('login_at', $currentMonth)->join('marketers', 'patron_logins.marketer_id', '=', 'marketers.marketer_id')
            ->selectRaw('marketers.marketer, COUNT(login_id) as marketerCounts')
            ->groupBy('marketers.marketer_id', 'marketers.marketer')
            ->orderByDesc('marketerCounts')
            ->limit(10)
            ->get();

        // Prepare data for charts
        $patronNames = $topPatrons->map(function ($patron) {
            return $patron->first_name . ' ' . $patron->last_name;
        })->toArray();

        $loginCounts = $topPatrons->pluck('logins')->toArray();
        $marketerNames = $topMarketers->pluck('marketer')->toArray();
        $marketerCounts = $topMarketers->pluck('marketerCounts')->toArray();

        // Pass the data to the view
        return view('reports.index', compact('patronNames', 'loginCounts', 'marketerNames', 'marketerCounts'));
    }
}
