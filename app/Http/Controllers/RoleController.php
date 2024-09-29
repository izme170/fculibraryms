<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    public function update(Request $request)
    {
        dd($request->roles);
        // Loop through each role submitted in the request
        foreach ($request->roles as $roleId => $roleData) {
            // Find the role by its ID
            $role = Role::findOrFail($roleId);

            // Update the access permissions based on the checkboxes
            $role->update([
                'books_access' => isset($roleData['books_access']),
                'patrons_access' => isset($roleData['patrons_access']),
                'reports_access' => isset($roleData['reports_access']),
            ]);
        }

        return redirect()->back();
    }
}
