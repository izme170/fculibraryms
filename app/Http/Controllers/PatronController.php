<?php

namespace App\Http\Controllers;

use App\Exports\PatronExport;
use App\Exports\UsersExport;
use App\Mail\SendPatronQRCode;
use App\Models\Activity;
use App\Models\Adviser;
use App\Models\BorrowedBook;
use App\Models\Course;
use App\Models\Department;
use App\Models\Patron;
use App\Models\PatronLogin;
use App\Models\PatronType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PatronController extends Controller
{
    public $finePerHour = 5;
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'first_name');
        $direction = $request->query('direction', 'asc');
        $course_filter = $request->query('course_filter', '');
        $department_filter = $request->query('deparment_filter', '');
        $type_filter = $request->query('type_filter', '');

        $query = Patron::with('type', 'department')
            ->where('is_archived', '=', false);

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('patrons.first_name', 'like', "%{$search}%")
                    ->orWhere('patrons.last_name', 'like', "%{$search}%");
            });
        }

        if (!empty($course_filter)) {
            $query->where('course_id', '=', $course_filter);
        }

        if (!empty($department_filter)) {
            $query->where('department_id', '=', $department_filter);
        }

        if (!empty($type_filter)) {
            $query->where('type_id', '=', $type_filter);
        }

        $patrons = $query->orderBy($sort, $direction)
            ->paginate(15)
            ->appends(['search', 'sort', 'direction', 'course_filter', 'department_filter', 'type_filter']);

        $patrons->each(function ($patron) use ($patrons) {
            $words = explode(' ', $patron->department->department);
            $ignoreWords = ['of', 'and', 'the', 'a', 'an', 'in'];
            $patron->department_acronym = implode('', array_map(function ($word) use ($ignoreWords) {
                return !in_array(strtolower($word), $ignoreWords) ? strtoupper($word[0]) : '';
            }, $words));
        });

        $courses = Course::all();
        $departments = Department::all();
        $types = PatronType::all();

        return view('patrons.index', compact('patrons', 'search', 'sort', 'direction', 'courses', 'departments', 'types'));
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

        $borrowed_books = BorrowedBook::with('patron')
        ->where('patron_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

        $borrowed_books->each(function ($borrowed_book) {

            //Checks if the book is returned
            if (!$borrowed_book->returned) {
                $dueDate = Carbon::parse($borrowed_book->due_date);
                $now = Carbon::now();

                //Check if the book is overdue
                if ($now->gt($dueDate)) {
                    $hoursOverdue = $dueDate->diffInHours($now, false);
                    $borrowed_book->fine = $this->finePerHour * (int)$hoursOverdue;
                } else {
                    $borrowed_book->fine = 0;
                }
            }
        });

        return view('patrons.show', compact('patron', 'patron_types', 'departments', 'advisers', 'borrowed_books'));
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
