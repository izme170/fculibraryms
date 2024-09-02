<?php

namespace App\Http\Controllers;

use App\Mail\SendPatronQRCode;
use App\Models\Adviser;
use App\Models\Course;
use App\Models\Department;
use App\Models\Patron;
use App\Models\PatronLogin;
use App\Models\PatronType;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class PatronController extends Controller
{
    public function index()
    {
        $patrons = Patron::all();

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
            'adviser_id' => ['required']
        ]);

        // Generate the QR code
        $qrcode = ($request->type_id == 1 ? 'stud' : 'fclty') . $request->school_id . rand(1000, 9999) . time();
        $validated['qrcode'] = $qrcode;

        // Create the patron record
        $patron = Patron::create($validated);

        // Return the view with the QR code and patron data
        return view('patrons.qrcode', compact('qrcode', 'patron'));
    }

    public function show($id){
        $patron = Patron::find($id);

        return view('patrons.show', compact('patron'));
    }


    public function getPatron($id)
    {
        $patron = Patron::where('qrcode', '=', $id)->first();

        // Debugging output
        // dd($patron);

        if ($patron) {
            return response()->json(['name' => $patron->first_name . ' ' . $patron->last_name, 'patron_id' => $patron->patron_id]);
        } else {
            return response()->json(['error' => 'Patron not found'], 404);
        }
    }

    public function sendQRCodeToEmail(Request $request, $id)
    {
        $patron = Patron::find($id); // Assuming you pass the patron ID via a query parameter or route
        $qrcode = $patron->qrcode;

        Mail::to($patron->email)->send(new SendPatronQRCode($qrcode));

        return redirect('/admin/patron/create');
    }

}
