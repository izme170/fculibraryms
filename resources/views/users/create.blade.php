@extends('layout.main')
@include('include.sidenav')
@section('user-content')
<div class="widget">
    <div class="form-container">
        <form action="/user/store" method="post">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label" for="role_id">Role</label>
                        <select id="role_id" name="role_id">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->role_id }}" {{ old('role_id') == $role->role_id ? 'selected' : '' }}>
                                    {{ $role->role }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="first_name">Firstname</label>
                        <input type="text" id="first_name" name="first_name" value="{{old('first_name')}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="middle_name">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" value="{{old('middle_name')}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="last_name">Lastname</label>
                        <input type="text" id="last_name" name="last_name" value="{{old('last_name')}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="text" id="email" name="email" value="{{old('email')}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="contact_number">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" value="{{old('contact_number')}}">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="username" value="{{old('username')}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password">
                    </div>
                </div>
            </div>
            <button class="btn-simple btn-right" type="submit">Submit</button>
        </form>
    </div>
</div>
@endsection
