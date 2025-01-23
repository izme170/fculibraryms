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
    <div class="bg-white rounded p-3" style="min-width: fit-content">
        <div class="d-flex flex-wrap justify-content-between gap-2">
            <div>
                <a class="btn-simple" href="/user/create">Add Users</a>
                <a class="btn-simple" href="/users/export">Export</a>
            </div>
            <div class="d-flex flex-column justify-content-between align-items-end">
                <!-- user search -->
                <form method="GET" action="/users" class="d-flex flex-row align-items-center" id="filterForm">
                    <input type="text" name="search" class="form-control" placeholder="Search user..."
                        value="{{ $search }}">
                    <button type="submit" class="btn-rectangle">Search</button>
                </form>
            </div>
            <div class="dropdown">
                <button class="btn text-white dropdown-toggle" style="background-color: #0E1133" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Filter
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="?role_filter=">All</a>
                    </li>
                    @foreach ($roles as $role)
                        <li>
                            <a class="dropdown-item" href="?role_filter={{ $role->role_id }}">
                                {{ $role->role }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-3 mt-3 justify-content-center">
            @foreach ($users as $user)
                <a class="card text-decoration-none" href="/user/show/{{ $user->user_id }}"
                    data-status="{{ $user->status }}">
                    <div class="indicator-container">
                        <div class="status-indicator {{$user->is_active ? 'active' : 'deactivated'}}"></div>
                    </div>
                    <img class="img" src="{{ $user->user_image ? asset('storage/' . $user->user_image) : asset('img/default-user-image.png') }}"
                        alt="User Image">
                    <div class="text">
                        <p class="h3">{{ $user->first_name }} {{ $user->last_name }}</p>
                        <p class="p">{{ $user->role->role }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $users->links() }}
        </div>
        {{-- <table class="table">
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
        </table> --}}
    </div>
@endsection
