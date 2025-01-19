<?php

namespace App\Http\Controllers;

use App\Models\Marketer;
use App\Models\Patron;
use App\Models\PatronLogin;
use App\Models\Purpose;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatronLoginController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $date = $request->query('date', '');

        $patron_logins = PatronLogin::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('patron', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                    })
                        ->orWhereHas('purpose', function ($query) use ($search) {
                            $query->where('purpose', 'like', "%$search%");
                        })
                        ->orWhereHas('marketer', function ($query) use ($search) {
                            $query->where('marketer', 'like', "%$search%");
                        });
                });
            })
            ->when($date, function ($query, $date) {
                $query->whereDate('login_at', $date); // Ensure date comparison is applied properly
            })
            ->with('patron', 'purpose', 'marketer')
            ->orderByDesc('login_at')
            ->paginate(10);

        return view('patron_logins.index', compact(['patron_logins', 'search', 'date']));
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
            'library_id' => 'required'
        ]);

        $patron = Patron::where('library_id', '=', $validated['library_id'])->first();

        if ($patron) {
            // Check if there is an existing login
            $existingLogin = PatronLogin::where('patron_id', $patron->patron_id)
                ->whereDate('created_at', now()->toDateString())
                ->whereNull('logout_at')
                ->first();

            if (!$existingLogin) {
                PatronLogin::create([
                    'patron_id' => $patron->patron_id,
                    'login_at' => now()
                ]);
                return response()->json([
                    'success' => true,
                    'patron_name' => $patron->first_name . ' ' . $patron->last_name,
                    'patron_id' => $patron->patron_id
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message_error' => "You are already logged in."
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message_error' => 'Your RFID is not registered.'
            ]);
        }
    }

    public function update(Request $request)
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

        if ($existingLogin) {
            $existingLogin->update($validated);
            $existingLogin->save();

            return response()->json([
                'success' => true,
                'message_success' => "Thank you for providing the purpose and marketer details!"
            ]);
        }

        return response()->json([
            'success' => false,
            'message_error' => "No existing login record found."
        ]);
    }



    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'library_id' => 'required'
    //     ]);

    //     $patron = Patron::where('library_id', '=', $validated['library_id'])->first();

    //     if ($patron) {
    //         // Check if there is an existing login
    //         $existingLogin = PatronLogin::where('patron_id', $patron->patron_id)
    //             ->whereDate('created_at', now()->toDateString())
    //             ->whereNull('logout_at')
    //             ->first();

    //         if (!$existingLogin) {
    //             PatronLogin::create([
    //                 'patron_id' => $patron->patron_id,
    //                 'login_at' => now()
    //             ]);
    //             return redirect('/patrons/login')->with(['patron' => $patron]);
    //         } else {
    //             return redirect('/patrons/login')->with('message_error_xl', "You are already logged in.");
    //         }
    //     } else {
    //         return redirect()->back()->with('message_error_xl', 'Your RFID is not registered.');
    //     }
    // }
    // public function update(Request $request)
    // {
    //     $validated = $request->validate([
    //         'patron_id' => 'required|integer',
    //         'purpose_id' => 'required|integer',
    //         'marketer_id' => 'nullable'
    //     ]);

    //     // Check if there is an existing logout
    //     $existingLogin = PatronLogin::where('patron_id', $request->patron_id)
    //         ->whereDate('created_at', now()->toDateString())
    //         ->whereNull('logout_at')
    //         ->first();

    //     $existingLogin->update($validated);
    //     $existingLogin->save();

    //     return redirect('/patrons/login')->with('message_success_xl', "Thank you for providing the purpose and marketer details!");
    // }

    public function logout()
    {
        return view('patron_logins.logout');
    }

    public function logoutProcess(Request $request)
    {
        $validated = $request->validate([
            'library_id' => 'required'
        ]);

        $patron = Patron::where('library_id', '=', $validated['library_id'])->first();

        if (!$patron) {
            return response()->json(['success' => false, 'message_error' => 'Patron not found.']);
        }

        // Perform logout operations
        $existingLogin = PatronLogin::where('patron_id', $patron->patron_id)
            ->whereDate('created_at', now()->toDateString())
            ->whereNull('logout_at')
            ->first();

        if ($existingLogin) {
            $existingLogin->logout_at = now();
            $existingLogin->save();

            return response()->json(['success' => true, 'message_success' => 'Thank you for visiting!']);
        }

        return response()->json(['success' => false, 'message_error' => 'You have not logged in today.']);
    }


    // public function logoutProcess(Request $request)
    // {
    //     $patron = Patron::where('library_id', '=', $request['library_id'])->first();

    //     if (!$patron) {
    //         return redirect()->back()->with('message_error', 'Patron not found. Please contact the Library admin');
    //     }

    //     $existingLogin = PatronLogin::where('patron_id', $patron->patron_id)
    //         ->whereDate('created_at', now()->toDateString())
    //         ->whereNull('logout_at')
    //         ->first();

    //     if ($existingLogin) {
    //         $existingLogin->logout_at = now();
    //         $existingLogin->save();

    //         return redirect()->back()->with('message_success_xl', 'Thank you for visiting FCU Library!');
    //     }

    //     return redirect()->back()->with('message_error_xl', 'You have not logged in today.');
    // }

}
