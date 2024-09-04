<?php

namespace App\Http\Controllers;

use App\Models\Marketer;
use App\Models\Patron;
use App\Models\PatronLogin;
use App\Models\Purpose;
use Illuminate\Http\Request;

class PatronLoginController extends Controller
{
    public function index()
    {
        $patron_logins = PatronLogin::all();
        return view('patron_logins.index', compact('patron_logins'));
    }
    public function create()
    {
        $purposes = Purpose::all();
        $marketers = Marketer::all();
        return view('patron_logins.create', compact('purposes', 'marketers'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patron_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'marketer_id' => 'nullable'
        ]);

        // Check if there is an existing logout
        $existingLogin = PatronLogin::where('patron_id', $request->patron_id)
            ->whereDate('created_at', now()->toDateString())
            ->whereNull('logout_at')
            ->first();

        if (!$existingLogin) {
            PatronLogin::create($validated);
            return redirect('/patrons/login')->with('message_success', 'Done!');
        } else {
            return redirect('/patrons/login')->with('message_error', "You already logged in.");
        }
    }

    public function edit()
    {
        return view('patron_logins.edit');
    }

    public function update(Request $request)
    {
        $patron = Patron::where('library_id', '=', $request['library_id'])->first();

        if (!$patron) {
            return redirect()->back()->with('message_error', 'Patron not found. Please contact the Library admin');
        }

        $existingLogin = PatronLogin::where('patron_id', $patron->patron_id)
            ->whereDate('created_at', now()->toDateString())
            ->whereNull('logout_at')
            ->first();

        if ($existingLogin) {
            $existingLogin->logout_at = now();
            $existingLogin->save();

            return redirect()->back()->with('message_success', 'Thank you for visiting FCU Library!');
        }

        return redirect()->back()->with('message_error', 'You have not logged in today.');
    }

}
