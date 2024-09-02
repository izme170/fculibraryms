<?php

namespace App\Http\Controllers;

use App\Models\Marketer;
use App\Models\Patron;
use App\Models\PatronLogin;
use App\Models\Purpose;
use Illuminate\Http\Request;

class PatronLoginController extends Controller
{
    public function create()
    {
        $purposes = Purpose::all();
        $marketers = Marketer::all();
        return view('patron_logins.create', compact('purposes', 'marketers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'patron_id' => 'required|string',
            'purpose_id' => 'required|integer',
            'marketer_id' => 'required|integer',
        ]);

        $login = new PatronLogin();
        $login->patron_id = $request->patron_id;
        $login->purpose_id = $request->purpose_id;
        $login->marketer_id = $request->marketer_id;

        if ($login->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
