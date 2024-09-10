<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class ActivityController extends Controller
{
    public function index(){
        $activities = Activity::leftJoin('books', 'activities.book_id', '=', 'books.book_id')
        ->leftJoin('patrons', 'activities.patron_id', '=', 'patrons.patron_id')
        ->leftJoin('users', 'activities.user_id', '=', 'users.user_id')
        ->select(
            'activities.*',
            'books.name',
            'patrons.first_name as patron_first_name',
            'users.first_name as user_first_name',
            'patrons.last_name as patron_last_name',
            'users.last_name as user_last_name'
        )
        ->get();
        return view('activities.index', compact('activities'));
    }
}
