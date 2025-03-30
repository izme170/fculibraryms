<?php

namespace App\Http\Controllers;

use App\Exports\PatronLoginsExport;
use App\Models\Marketer;
use App\Models\Patron;
use App\Models\PatronLogin;
use App\Models\Purpose;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PatronLoginController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $startDate = $request->query('startDate', '');
        $endDate = $request->query('endDate', '');
        $startDate = !empty($startDate) ? Carbon::parse($startDate)->startOfDay() : null;
        $endDate = !empty($endDate) ? Carbon::parse($endDate)->endOfDay() : null;


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
            ->when(!empty($startDate) && empty($endDate), fn($q) => $q->where('login_at', '>=', $startDate))
            ->when(empty($startDate) && !empty($endDate), fn($q) => $q->where('login_at', '<=', $endDate))
            ->when(!empty($startDate) && !empty($endDate), fn($q) => $q->whereBetween('login_at', [$startDate, $endDate]))
            ->with('patron', 'purpose', 'marketer')
            ->orderByDesc('login_at')
            ->paginate(10);

        return view('patron_logins.index', compact(['patron_logins', 'search', 'startDate', 'endDate']));
    }

    public function create()
    {
        $purposes = Purpose::where('show_in_forms', true)->get();
        $marketers = Marketer::where('show_in_forms', true)->get();
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
                    // 'patron_name' => $patron->first_name . ' ' . $patron->last_name,
                    // 'patron_id' => $patron->patron_id
                    'patron' => [
                        'image' => $patron->patron_image
                            ? asset('storage/' . $patron->patron_image)
                            : asset('img/default-patron-image.png'),
                        'name' => $patron->first_name . ' ' . $patron->last_name,
                        'id' => $patron->patron_id
                    ]
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

    public function export(Request $request)
    {
        return Excel::download(
            new PatronLoginsExport(
                $request->query('search', ''),
                $request->query('startDate', ''),
                $request->query('endDate', '')
            ),
            'patron_logins.xlsx'
        );
    }
}
