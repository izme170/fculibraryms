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
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            if(Auth::user()->is_active == false){
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Your account has been deactivated.'
                ])->onlyInput('username');
            }
            $request->session()->regenerate();

            // Record Activity
            $data = [
                'action' => 'has logged into the system.',
                'initiator_id' => Auth::id()
            ];
            Activity::create($data);

            return redirect('/user/dashboard')->with('message_success', 'Welcome back, ' . Auth::user()->first_name . '!');
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

    public function index(Request $request){
        $search = $request->search;
        $role_filter = $request->role_filter;
        $users = User::with('role:role_id,role')
        ->orderBy('users.role_id')
        ->orderBy('first_name')
        ->where('is_archived', false)
        ->when($search, function($query, $search){
            return $query->where('first_name', 'like', "%$search%")
            ->orWhere('middle_name', 'like', "%$search%")
            ->orWhere('last_name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('contact_number', 'like', "%$search%")
            ->orWhere('username', 'like', "%$search%");
        })
        ->when($role_filter, function($query, $role_filter){
            return $query->where('role_id', $role_filter);
        })
        ->paginate(15);

        $roles = Role::all();

        return view('users.index', compact(['users', 'search', 'roles']));
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
            'password' => 'required|min:5',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $validated['password'] = bcrypt($request->password);

        if($request->hasFile('user_image')){
            $file = $request->file('user_image');

            // Generate a unique filename
            $filenameToStore = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file
            $path = $file->storeAs('img/users', $filenameToStore, 'public');

            if($path){
                $validated['user_image'] = str_replace('public/', '', $path); // Save relative path
            } else {
                return back()->withErrors(['user_image' => 'Failed to upload the image.']);
            }
        }

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
        $user = User::with('role:role_id,role')->find($id);
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

    public function updateImage(Request $request, $id){
        $validated = $request->validate([
            'user_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = User::find($id);

        if($request->hasFile('user_image')){
            $file = $request->file('user_image');

            // Generate a unique filename
            $filenameToStore = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file
            $path = $file->storeAs('img/users', $filenameToStore, 'public');

            // Delete the old image if it exists
            if($user->user_image){
                $oldImagePath = public_path('storage/' . $user->user_image);
                if(file_exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }

            if($path){
                $user->update(['user_image' => str_replace('public/', '', $path)]); // Save relative path
            } else {
                return back()->withErrors(['user_image' => 'Failed to upload the image.']);
            }
        }

        // Record Activity
        $data = [
            'action' => 'updated the image of a user.',
            'user_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_success', 'User image has been updated.');
    }

    public function archive($id){
        User::find($id)->update(['is_archived' => true, 'is_active' => false]);

        // Record Activity
        $data = [
            'action' => 'archived a user in the system.',
            'user_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/users')->with('message_success', 'User has been archived and deactivated!');
    }

    public function changePassword(Request $request, $id){
        $user = User::find($id);

        //check if old password is empty
        if(empty($request->old_password)){
            return redirect()->back()->withErrors(['old_password' => 'The old password is required.']);
        }

        //validate the request
        $validated = $request->validate([
            'password' => 'required|confirmed|min:5'
        ]);

        //check if old password is correct
        if(!Hash::check($request->old_password, $user->password)){
            return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        //check if new password is the same as the old password
        if($request->old_password == $request->password){
            return redirect()->back()->withErrors(['password' => 'New password must be different from the old password.']);
        }

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

    public function deactivate($id){
        $user = User::findOrFail($id);
        $user->update(['is_active' => false]);

        // Record Activity
        $data = [
            'action' => 'deactivated a user account.',
            'user_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_success', 'User account has been deactivated!');
    }

    public function activate($id){
        User::find($id)->update(['is_active' => true]);

        // Record Activity
        $data = [
            'action' => 'activated a user account.',
            'user_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_success', 'User account has been activated!');
    }
}
