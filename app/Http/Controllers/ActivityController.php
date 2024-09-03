<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class ActivityController extends Controller
{
    public function index(){
        $activities = Activity::all();
        return view('activities.index', compact('activities'));
    }
}
