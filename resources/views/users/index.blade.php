@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
<a class="btn-simple" href="/admin/user/create">Add Users</a>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Role</th>
            <th scope="col">Contact Number</th>
            <th scope="col">Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr onclick="window.location.href='/admin/user/show/{{$user->user_id}}';" style="cursor:pointer;">
                <td>{{$user->first_name . ' ' . $user->last_name}}</td>
                <td>{{$user->role}}</td>
                <td>{{$user->contact_number}}</td>
                <td>{{$user->email}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- <table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Contact Number</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{$user->first_name . ' ' . $user->last_name}}</td>
                <td>{{$user->role_id}}</td>
                <td>{{$user->contact_number}}</td>
                <td>{{$user->email}}</td>
            </tr>
        @endforeach
    </tbody>
</table> -->
@endsection