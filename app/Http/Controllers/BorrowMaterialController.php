<?php

namespace App\Http\Controllers;

use App\Exports\BorrowedMaterialsExport;
use App\Models\Material;
use App\Models\BorrowedMaterial;
use App\Models\Condition;
use App\Models\MaterialCopy;
use App\Models\Patron;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\isNull;

class BorrowMaterialController extends Controller
{
    private $finePerHour;

    public function __construct()
    {
        $this->finePerHour = (float) Setting::where('key', 'fine')->first()->value ?? 5.00;
    }

    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');
        $startDate = $request->query('startDate', '');
        $endDate = $request->query('endDate', '');
        $startDate = !empty($startDate) ? Carbon::parse($startDate)->startOfDay() : null;
        $endDate = !empty($endDate) ? Carbon::parse($endDate)->endOfDay() : null;
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');

        $query = BorrowedMaterial::query()
            ->when($status === 'returned', fn($q) => $q->whereNotNull('returned'))
            ->when($status === 'borrowed', fn($q) => $q->whereNull('returned'))
            ->when($status === 'overdue', fn($q) => $q->whereNull('returned')->where('due_date', '<', now()));


        if (!empty($search)) {
            $query->whereHas('materialCopy.material', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->orWhereHas('patron', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if (!empty($startDate) || !empty($endDate)) {
            $start = !empty($startDate) ? Carbon::parse($startDate)->startOfDay() : null;
            $end = !empty($endDate) ? Carbon::parse($endDate)->endOfDay() : null;

            if ($start && $end) {
                $query->whereBetween('created_at', [$start, $end]);
            } elseif ($start) {
                $query->where('created_at', '>=', $start);
            } elseif ($end) {
                $query->where('created_at', '<=', $end);
            }
        }

        $fine = $this->finePerHour;

        $borrowed_materials = $query->orderBy($sort, $direction)->paginate(10)->appends(['search', 'status', 'sort', 'direction', 'startDate', 'endDate']);
        return view('borrow_materials.index', compact(['borrowed_materials', 'search', 'status', 'sort', 'direction', 'startDate', 'endDate', 'fine']));
    }

    public function show($id)
    {
        $borrowed_material = BorrowedMaterial::findOrFail($id);
        return view('borrow_materials.show', compact('borrowed_material'));
    }

    public function create()
    {
        $conditions = Condition::all();
        return view('borrow_materials.create', compact('conditions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'library_id' => 'required|exists:patrons,library_id',
            'rfid' => 'required|exists:material_copies,rfid',
            'condition_id' => 'nullable|exists:conditions,condition_id',
        ]);

        $patron = Patron::where('library_id', '=', $validated['library_id'])->first();
        $copy = MaterialCopy::where('rfid', '=', $validated['rfid'])->first();

        if (!$copy->is_available) {
            return redirect()->back()->withErrors('This material is currently not available for borrowing.');
        }

        $data = [
            'patron_id' => $patron->patron_id,
            'copy_id' => $copy->copy_id,
            'user_id' => Auth::id(),
        ];

        if ($validated['condition_id'] != null) {
            $data['condition_before'] = $validated['condition_id'];
        }

        if ($request['due'] == 'oneHour') {
            $data['due_date'] = Carbon::now()->addHours(1);
        } else {
            $data['due_date'] = Carbon::now()->adddays(1);
        }

        BorrowedMaterial::create($data);
        $copy->update(['is_available' => false]);
        return redirect()->back()->with('message_success', 'Material borrowed successfully');
    }

    public function edit()
    {
        $conditions = Condition::all();
        return view('borrow_materials.edit', compact('conditions'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'rfid' => 'required|exists:material_copies,rfid',
            'condition_id' => 'required|exists:conditions,condition_id'
        ]);

        $copy = MaterialCopy::where('rfid', '=', $validated['rfid'])->first();
        $borrowed_material = BorrowedMaterial::where('copy_id', '=', $copy->copy_id)->whereNull('returned')->first();

        if ($borrowed_material) {
            $dueDate = Carbon::parse($borrowed_material->due_date);
            $now = Carbon::now();
            $borrowed_material->returned = $now;

            // Check if the material is overdue
            if ($now->gt($dueDate)) {
                $hoursOverdue = $dueDate->diffInHours($now);
                $borrowed_material->fine = $this->finePerHour * (int)$hoursOverdue;
            } else {
                $borrowed_material->fine = 0;
            }

            $borrowed_material->condition_after = $validated['condition_id'];

            $borrowed_material->save();

            // Make the material available
            $copy->update(['is_available' => true]);
        } else {
            return redirect()->back()->with('message_error', 'Material is not found in the Borrowed List');
        }
        return redirect()->back()->with('message_success', 'Material returned successfully');
    }

    public function export(Request $request)
    {
        return Excel::download(
            new BorrowedMaterialsExport(
                $request->query('status', 'all'),
                $request->query('search', ''),
                $request->query('startDate', ''),
                $request->query('endDate', '')
            ),
            'borrowed_materials.xlsx'
        );
    }
}
