<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('role_id', '!=', 1)->get();

        return view('roles.index', compact('roles'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'role' => 'required'
        ]);

        Role::insert($validated);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $materials_access = $request->has('materials_access') ? true : false;
        $patrons_access = $request->has('patrons_access') ? true : false;
        $reports_access = $request->has('reports_access') ? true : false;

        Role::where('role_id', '=',$id)->update([
            'materials_access' => $materials_access,
            'patrons_access' => $patrons_access,
            'reports_access' => $reports_access,
        ]);

        return redirect()->back();
    }
}
