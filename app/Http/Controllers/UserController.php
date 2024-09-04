<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Role;
use App\Models\User;
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
        $users = User::all();

        return view('users.index', compact('users'));
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

        return redirect('/admin/users');
    }

    public function show($id){
        $user = User::find($id);

        return view('users.show', compact('user'));
    }
}
