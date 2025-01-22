<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request){
        $search = $request->search;
        $date = $request->date;

        $activities = Activity::with(['book:book_id,title', 'patron:patron_id,first_name,last_name', 'user:user_id,first_name,last_name', 'initiator:user_id,first_name,last_name'])
        ->when($search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('patron', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%");
                })
                    ->orWhereHas('book', function ($query) use ($search) {
                        $query->where('title', 'like', "%$search%");
                    })
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                    })
                    ->orWhereHas('initiator', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                    });
            });
        })
        ->when($date, function ($query, $date) {
            $query->whereDate('created_at', $date);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('activities.index', compact(['activities', 'search', 'date']));
    }
}
