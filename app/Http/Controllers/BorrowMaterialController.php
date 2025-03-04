<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\BorrowedMaterial;
use App\Models\Patron;
use App\Models\Remark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class BorrowMaterialController extends Controller
{
    private $finePerHour = 5;
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');

        $query = BorrowedMaterial::query();

        if($status != 'all'){
            if($status == 'returned'){
                $query = BorrowedMaterial::whereNotNull('returned');
            }elseif($status == 'borrowed'){
                $query = BorrowedMaterial::whereNull('returned')->where('due_date', '>=', now());
            }elseif($status == 'overdue'){
                $query = BorrowedMaterial::whereNull('returned')->where('due_date', '<', now());
            }
        }

        if(!empty($search)){
            $query->whereHas('materialCopy.material', function ($q) use ($search){
                $q->where('title', 'like', "%{$search}%" );
            })->orWhereHas('patron', function ($q) use ($search){
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search){
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $borrowed_materials = $query->orderBy($sort, $direction)->paginate(10);

        // $query = BorrowedMaterial::with(['material:material_id,title', 'patron:patron_id,first_name,last_name', 'user:user_id,first_name,last_name'])
        // ->join('materials', 'borrowed_materials.material_id', '=', 'materials.material_id')
        // ->join('patrons', 'borrowed_materials.patron_id', '=', 'patrons.patron_id')
        // ->join('users', 'borrowed_materials.user_id', '=', 'users.user_id')
        // ->select('borrowed_materials.*', 'materials.title', 'patrons.first_name as patrons_name', 'users.first_name as users_name');

        // if (!empty($search)) {
        //     $query->whereHas('material', function ($query) use ($search) {
        //         $query->where('title', 'like', "%{$search}%");
        //     })->orWhereHas('patron', function ($query) use ($search) {
        //         $query->where('first_name', 'like', "%{$search}%")
        //             ->orWhere('first_name', 'like', "%{$search}%");
        //     })->orWhereHas('user', function ($q) use ($search) {
        //         $q->where('first_name', 'like', "%{$search}%")
        //             ->orWhere('last_name', 'like', "%{$search}%");
        //     });
        // }

        // if ($status !== 'all') {
        //     if ($status === 'returned') {
        //         $query->whereNotNull('returned');
        //     } elseif ($status === 'borrowed') {
        //         $query->whereNull('returned')
        //             ->where('due_date', '>=', now());
        //     } elseif ($status === 'overdue') {
        //         $query->whereNull('returned')
        //             ->where('due_date', '<', now());
        //     }
        // }

        // $borrowed_materials = $query->orderBy($sort, $direction)
        //     ->paginate(10)
        //     ->appends(['search' => $search, 'status' => $status, 'sort' => $sort, 'direction' => $direction]);

        // $borrowed_materials->each(function ($borrowed_material) {
        //     //Checks if the material is returned
        //     if (!$borrowed_material->returned) {
        //         $dueDate = Carbon::parse($borrowed_material->due_date);
        //         $now = Carbon::now();
        //         //Check if the material is overdue
        //         if ($now->gt($dueDate)) {
        //             $hoursOverdue = $dueDate->diffInHours($now, false);
        //             $borrowed_material->fine = $this->finePerHour * (int)$hoursOverdue;
        //         } else {
        //             $borrowed_material->fine = 0;
        //         }
        //     }
        // });

        return view('borrow_materials.index', compact(['borrowed_materials', 'search', 'status', 'sort', 'direction']));
    }

    public function create()
    {
        return view('borrow_materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'library_id' => 'required|exists:patrons,library_id',
            'material_rfid' => 'required|exists:materials,material_rfid'
        ]);

        $patron = Patron::where('library_id', '=', $validated['library_id'])->first();
        $material = Material::where('material_rfid', '=', $validated['material_rfid'])->first();
        $data = [
            'patron_id' => $patron->patron_id,
            'material_id' => $material->material_id,
            'user_id' => Auth::id(),
        ];

        if ($request['due'] == 'oneHour') {
            $data['due_date'] = Carbon::now()->addHours(1);
        } else {
            $data['due_date'] = Carbon::now()->adddays(1);
        }

        BorrowedMaterial::create($data);
        $material->update(['is_available' => false]);
        return redirect()->back();
    }

    public function edit()
    {
        $remarks = Remark::all();
        return view('borrow_materials.edit', compact('remarks'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'material_rfid' => 'required|exists:materials,material_rfid',
            'remark_id' => 'required|exists:remarks,remark_id'
        ]);

        $material = Material::where('material_rfid', '=', $validated['material_rfid'])->first();
        $borrowed_material = BorrowedMaterial::where('material_id', '=', $material->material_id)->whereNull('returned')->first();

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

            $borrowed_material->remark_id = $validated['remark_id'];

            $borrowed_material->save();

            // Make the material available
            $material->update(['is_available' => true]);
        } else {
            return redirect()->back()->with('message_error', 'Material is not found in the Borrowed List');
        }
        return redirect('/materials');
    }
}
