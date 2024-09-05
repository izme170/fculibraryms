<?php

namespace App\Http\Controllers;

use App\Mail\SendPatronQRCode;
use App\Models\Activity;
use App\Models\Adviser;
use App\Models\Course;
use App\Models\Department;
use App\Models\Patron;
use App\Models\PatronLogin;
use App\Models\PatronType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class PatronController extends Controller
{
    public function index()
    {
        $patrons = Patron::leftJoin('patron_types', 'patrons.type_id', '=', 'patron_types.type_id')
        ->orderBy('patrons.type_id')
        ->orderBy('first_name')->get();

        return view('patrons.index', compact('patrons'));
    }

    public function create()
    {
        $patron_types = PatronType::all();
        $departments = Department::all();
        $courses = Course::all();
        $advisers = Adviser::all();

        return view('patrons.create', compact(['patron_types', 'departments', 'courses', 'advisers']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'email' => ['email', 'required'],
            'contact_number' => ['required'],
            'type_id' => ['required'],
            'address' => ['required'],
            'school_id' => ['required'],
            'department_id' => ['required'],
            'course_id' => ['required'],
            'year' => ['required', 'numeric'],
            'library_id' => ['required'],
            'adviser_id' => ['required']
        ]);

        // Generate the QR code
        // $library_id = ($request->type_id == 1 ? 'stud' : 'fclty') . $request->school_id . rand(1000, 9999) . time();
        // $validated['library_id'] = $library_id;

        // Create the patron record
        $patron = Patron::create($validated);

        // Record Activity
        $data = [
            'action' => 'Add Patron',
            'patron_id' => $patron->patron_id,
            'user_id' => Auth::id()
        ];
        Activity::create($data);

        // Return the view with the QR code and patron data
        // return view('patrons.qrcode', compact('library_id', 'patron'));
        return redirect('/admin/patrons');
    }

    public function show($id)
    {
        $patron = Patron::find($id);

        return view('patrons.show', compact('patron'));
    }


    public function getPatron($rfid)
    {
        $patron = Patron::where('library_id', '=', $rfid)->first();

        if ($patron) {
            return response()->json(['name' => $patron->first_name . ' ' . $patron->last_name, 'patron_id' => $patron->patron_id]);
        } else {
            return response()->json(['error' => 'Patron not found'], 404);
        }
    }

    // public function sendQRCodeToEmail(Request $request, $id)
    // {
    //     $patron = Patron::find($id);
    //     $library_id = $patron->library_id;

    //     Mail::to($patron->email)->send(new SendPatronQRCode($library_id));

    //     return redirect('/admin/patron/create');
    // }

}
