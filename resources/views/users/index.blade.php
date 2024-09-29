@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/users">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/roles">Roles</a>
        </li>
    </ul>
    <a class="btn-simple" href="/user/create">Add Users</a>
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
                <tr onclick="window.location.href='/user/show/{{ $user->user_id }}';" style="cursor:pointer;">
                    <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->contact_number }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
