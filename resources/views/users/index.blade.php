@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/users">Users</a>
        </li>
        <li class="nav-item bg-secondary rounded-top">
            <a class="nav-link text-black" href="/roles">Roles</a>
        </li>
    </ul>
    <div class="container p-3">
        <a class="btn-simple" href="/user/create">Add Users</a>
        <a class="btn-simple" href="/users/export">Export</a>
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
                        <td>{{ $user->role->role }}</td>
                        <td>{{ $user->contact_number }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
