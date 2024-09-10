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

        $patron = Patron::create($validated);

        // Record Activity
        $data = [
            'action' => 'Add patron',
            'patron_id' => $patron->patron_id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/patrons');
    }

    public function show($id)
    {
        $patron = Patron::find($id);

        return view('patrons.show', compact('patron'));
    }
}
