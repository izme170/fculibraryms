<?php

namespace App\Http\Controllers;

use App\Models\FundingSource;
use App\Models\MaterialCopy;
use App\Models\Vendor;
use Illuminate\Http\Request;

class MaterialCopyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status', 'all');
        $copies = MaterialCopy::where('is_archived' , false);
        if ($search) {
            $copies = MaterialCopy::where('copy_number', 'like', '%' . $search . '%')
                ->orWhere('accession_number', 'like', '%' . $search . '%')
                ->orWhere('call_number', 'like', '%' . $search . '%')
                ->orWhere('rfid', 'like', '%' . $search . '%')
                ->orWhereHas('material', function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                });
        }

        if ($status !== 'all') {
            if ($status === 'available') {
                $copies = $copies->where('is_available', true);
            } elseif ($status === 'borrowed') {
                $copies = $copies->where('is_available', false);
            } elseif ($status === 'overdue') {
                $copies = $copies->where('is_available', false)
                    ->whereHas('borrowedCopies', function ($query) {
                        $query->where('due_date', '<', now());
                    });
            }
        }

        $copies = $copies->paginate(10);
        return view('material_copies.index', compact('copies', 'search', 'status'));
    }
    public function show($id)
    {
        $copy = MaterialCopy::find($id);
        $vendors = Vendor::all();
        $funds = FundingSource::all();
        return view('material_copies.show', compact('copy', 'vendors', 'funds'));
    }

    public function create($id)
    {
        $vendors = Vendor::all();
        $funds = FundingSource::all();
        return view('material_copies.create', compact('vendors', 'funds', 'id'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'copy_number' => 'nullable',
            'call_number' => 'nullable',
            'accession_number' => 'nullable',
            'vendor_id' => 'nullable',
            'fun_id' => 'nullable',
            'price' => 'nullable',
            'date_acquired' => 'nullable',
        ]);

        $copy = new MaterialCopy();
        $copy->copy_number = $request->copy_number;
        $copy->accession_number = $request->accession_number;
        $copy->call_number = $request->call_number;
        $copy->material_id = $id;
        $copy->vendor_id = $request->vendor_id;
        $copy->fund_id = $request->fun_id;
        $copy->price = $request->price;
        $copy->date_acquired = $request->date_acquired;
        $copy->rfid = $request->rfid;
        $copy->save();

        return redirect('material/show/' . $id)->with('success', 'Material copy added successfully');
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'copy_number' => 'nullable',
            'call_number' => 'nullable',
            'accession_number' => 'nullable',
            'vendor_id' => 'nullable',
            'fun_id' => 'nullable',
            'price' => 'nullable',
            'date_acquired' => 'nullable'
        ]);

        $copy = MaterialCopy::findOrFail($id);
        $copy->update($validated);

        return redirect()->back()->with('success', 'Material copy updated successfully');
    }

    public function archive($id){
        $copy = MaterialCopy::findOrFail($id);
        $copy->is_archived = true;
        $copy->save();

        return redirect()->back()->with('success', 'Material copy archived successfully');
    }

    public function unarchive($id){
        $copy = MaterialCopy::findOrFail($id);
        $copy->is_archived = false;
        $copy->save();

        return redirect()->back()->with('success', 'Material copy unarchived successfully');
    }

    public function updateRFID($id){

        $validated = request()->validate([
            'rfid' => 'required'
        ]);

        $copy = MaterialCopy::findOrFail($id);
        $copy->update($validated);

        return redirect()->back()->with('success', 'RFID updated successfully');
    }
}
