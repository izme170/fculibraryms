<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class ActivityController extends Controller
{
    public function index(){
        $activities = Activity::with(['book:book_id,title', 'patron:patron_id,first_name,last_name', 'user:user_id,first_name,last_name', 'initiator:user_id,first_name,last_name'])
        ->get();
        return view('activities.index', compact('activities'));
    }
}
