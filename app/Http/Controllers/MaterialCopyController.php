<?php

namespace App\Http\Controllers;

use App\Models\FundingSource;
use App\Models\MaterialCopy;
use App\Models\Vendor;
use Illuminate\Http\Request;

class MaterialCopyController extends Controller
{
    public function show($id)
    {
        $copy = MaterialCopy::find($id);
        return view('material_copies.show', compact('copy'));
    }

    public function create($id)
    {
        $vendors = Vendor::all();
        $funds = FundingSource::all();
        return view('material_copies.create', compact('vendors', 'funds', 'id'));
    }

    public function store(Request $request, $id){
        $request->validate([
            'copy_number' => 'required',
            'call_number' => 'required',
            'accession_number' => 'required',
            'vendor_id' => 'nullable',
            'fun_id' => 'nullable',
            'price' => 'nullable',
            'date_acquired' => 'nullable',
            'rfid' => 'required'
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

        return redirect('material/show/'.$id)->with('success', 'Material copy added successfully');
    }
}
