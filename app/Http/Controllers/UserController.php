<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Activity;
use App\Models\Role;
use App\Models\User;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            // Record Activity
            $data = [
                'action' => 'has logged into the system.',
                'initiator_id' => Auth::id()
            ];
            Activity::create($data);

            return redirect('/user/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not march our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request): RedirectResponse
    {
        // Record Activity
        $data = [
            'action' => 'has logged out of the system.',
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function index(){
        $users = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->orderBy('users.role_id')
        ->orderBy('first_name')
        ->where('is_archived', false)
        ->get();

        return view('users.index', compact(['users']));
    }

    public function create(){
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'email' => 'email|nullable',
            'contact_number' => 'required_without:email',
            'role_id' => 'required',
            'username' => 'required',
            'password' => 'required|min:5'
        ]);

        $validated['password'] = bcrypt($request->password);

        $id = User::create($validated);

        // Record Activity
        $data = [
            'action' => 'created a new user account.',
            'user_id' => $id->user_id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/users');
    }

    public function show($id){
        $user = User::leftJoin('roles', 'users.role_id', '=', 'roles.role_id')->find($id);
        $roles = Role::all();

        return view('users.show', compact(['user', 'roles']));
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'role_id' => 'required',
            'first_name' => 'required|string:55',
            'middle_name' => 'nullable',
            'last_name' => 'required|string:55',
            'email' => 'nullable|email',
            'contact_number' => 'required_without:email',
            'username'=> 'required|unique:users,username,'.$id.',user_id'
        ]);

        User::find($id)->update($validated);

        // Record Activity
        $data = [
            'action' => 'updated a user details.',
            'user_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/user/show/' . $id)->with('message_success', 'The user\'s details have been updated!');
    }

    public function archive($id){
        User::find($id)->update(['is_archived' => true]);

        // Record Activity
        $data = [
            'action' => 'archived a user in the system.',
            'user_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/users')->with('message_success', 'User has been archived!');
    }

    public function changePassword(Request $request, $id){
        $validated = $request->validate([
            'password' => 'required|confirmed|min:5'
        ]);

        // Record Activity
        $data = [
            'action' => 'changed the password of a user.',
            'user_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        User::find($id)->update(['password' => bcrypt($validated['password'])]);

        return redirect()->back()->with('message_success', 'Password successfully updated!');
    }

    public function export(){
        return Excel::download(new UsersExport, 'users-library-management-system.xlsx');
    }
}
