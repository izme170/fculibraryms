<?php

namespace App\Http\Controllers;

use App\Models\BorrowedBook;
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
        $total_visits_today = PatronLogin::whereDate('login_at', Carbon::today())->count();

        //$ List of Unreturned Books
        $unreturned_books_list = BorrowedBook::where('returned', null)
        ->join('books', 'borrowed_books.book_id', '=', 'books.book_id')
        ->get();

        // Total Unreturned Books
        $total_unreturned_books = $unreturned_books_list->count();

        return view('users.dashboard', compact('visits', 'total_visits_today', 'total_unreturned_books', 'unreturned_books_list'));
    }
}
