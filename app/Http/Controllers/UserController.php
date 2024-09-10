<?php

namespace App\Http\Controllers;

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
                'action' => 'Login',
                'user_id' => Auth::id()
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
            'action' => 'Logout',
            'user_id' => Auth::id()
        ];
        Activity::create($data);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function index(){
        $users = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->orderBy('first_name')
        ->orderBy('users.role_id')
        ->get();

        return view('users.index', compact(['users']));
    }

    public function create(){
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'email' => ['email', 'required'],
            'contact_number' => ['required'],
            'role_id' => ['required'],
            'username' => ['required'],
            'password' => ['required']
        ]);

        $validated['password'] = bcrypt($request->password);

        User::create($validated);

        return redirect('/users');
    }

    public function show($id){
        $user = User::leftJoin('roles', 'users.role_id', '=', 'roles.role_id')->find($id);

        return view('users.show', compact('user'));
    }

    public function edit($id){
        $user = User::find($id);
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'role_id' => 'required',
            'first_name' => 'required|string:55',
            'middle_name' => 'nullable',
            'last_name' => 'required|string:55',
            'email' => 'required|email',
            'contact_number' => 'required',
            'username'=> 'required|unique:users,username,'.$id.',user_id'
        ]);

        User::find($id)->update($validated);

        return redirect('/user/show/' . $id);
    }
}
