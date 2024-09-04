<?php

namespace App\Http\Controllers;

use App\Models\PatronLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // Get the current week range
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Fetch daily visit counts for the current week
        $dailyVisits = PatronLogin::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->selectRaw('DAYOFWEEK(created_at) as day, COUNT(*) as visits')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('visits', 'day');

        // Format the data for the view
        $visits = [];
        for ($day = 1; $day <= 7; $day++) {
            $visits[$day] = $dailyVisits->get($day, 0);  // Default to 0 if no visits for that day
        }

        return view('users.dashboard', compact('visits'));
    }
}
