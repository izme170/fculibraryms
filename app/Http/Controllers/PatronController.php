<?php

namespace App\Http\Controllers;

use App\Exports\PatronExport;
use App\Exports\UsersExport;
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
use Maatwebsite\Excel\Facades\Excel;

class PatronController extends Controller
{
    public function index()
    {
        $patrons = Patron::with('type')
            ->where('is_archived', '=', false)
            ->orderBy('patrons.type_id')
            ->orderBy('first_name')->get();

        return view('patrons.index', compact('patrons'));
    }

    public function create()
    {
        $patron_types = PatronType::all();
        $departments = Department::all();
        $advisers = Adviser::all();

        return view('patrons.create', compact(['patron_types', 'departments', 'advisers']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'email' => 'nullable|email',
            'contact_number' => 'required_without:email',
            'type_id' => 'required',
            'address' => 'required',
            'school_id' => 'nullable',
            'department_id' => 'nullable',
            'course_id' => 'nullable',
            'year' => 'nullable|numeric',
            'library_id' => 'nullable|unique:patrons,library_id',
            'adviser_id' => 'nullable'
        ]);

        $patron = Patron::create($validated);

        // Record Activity
        $data = [
            'action' => 'added a new patron profile',
            'patron_id' => $patron->patron_id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/patrons');
    }

    public function show($id)
    {
        $patron = Patron::with(['type', 'department', 'course', 'adviser'])
        ->find($id);

        $patron_types = PatronType::all();
        $departments = Department::all();
        $advisers = Adviser::all();

        return view('patrons.show', compact('patron', 'patron_types', 'departments', 'advisers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'email' => 'nullable|email',
            'contact_number' => 'required_without:email',
            'type_id' => 'required',
            'address' => 'required',
            'school_id' => 'nullable',
            'department_id' => 'nullable',
            'course_id' => 'nullable',
            'year' => 'nullable|numeric',
            'adviser_id' => 'nullable'
        ]);

        Patron::find($id)->update($validated);

        // Record Activity
        $data = [
            'action' => 'updated a patron profile',
            'patron_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_success', 'Success! The patron\'s profile has been updated.');
    }

    public function archive($id)
    {
        Patron::find($id)->update(['is_archived' => true]);

        // Record Activity
        $data = [
            'action' => 'archives patron profile',
            'patron_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/patrons')->with('message_success', 'The patron\'s profile has been archived.');
    }

    public function newRFID(Request $request, $id)
    {
        $validated = $request->validate([
            'library_id' => 'required|unique:patrons,library_id'
        ]);

        Patron::find($id)->update($validated);

        // Record Activity
        $data = [
            'action' => 'assigned new RFID to the patron',
            'patron_id' => $id,
            'initiator_id' => Auth::id()
        ];

        return redirect()->back()->with('success_message', 'Patron\'s RFID updated.');
    }

    public function getCoursesByDepartment($department_id)
    {
        $courses = Course::where('department_id', $department_id)->get();
        return response()->json($courses);
    }

    public function export()
    {
        return Excel::download(new PatronExport, 'patrons-library-management-system.xlsx');
    }
}
