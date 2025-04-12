<?php

namespace App\Http\Controllers;

use App\Models\BorrowedMaterial;
use App\Models\Material;
use App\Models\Patron;
use App\Models\PatronLogin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $user_count = User::where('is_active', true)->count();
        $patron_count = Patron::whereNot('is_archived')->count();
        $material_count = Material::whereNot('is_archived')->count();

        // Get the current week range
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Fetch daily visit counts for the current week
        $dailyVisits = PatronLogin::whereBetween('login_at', [$startOfWeek, $endOfWeek])
            ->selectRaw('DAYOFWEEK(login_at) as day, COUNT(*) as visits')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('visits', 'day');

        // Format the data for the view
        $visits = [];
        for ($day = 2; $day <= 7; $day++) {
            $visits[] = $dailyVisits->get($day, 0);  // Default to 0 if no visits for that day
        }
        // Puts the sunday to the last of the array
        $visits[] = $dailyVisits->get(1, 0);

        // Get the total visit today
        $visits_today = PatronLogin::whereDate('login_at', Carbon::today())->count();

        //$ List of Unreturned Materials
        $unreturnedMaterials = BorrowedMaterial::with('materialCopy.material')
        ->whereNull('returned')
        ->get();

        $patron_logins = PatronLogin::whereDate('login_at', Carbon::today())->get();

        return view('users.dashboard', compact('visits', 'visits_today', 'unreturnedMaterials', 'user_count', 'patron_count', 'material_count', 'patron_logins'));
    }
}
