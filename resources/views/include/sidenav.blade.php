@php
    $user = auth()->user()->load('role');
@endphp

<div class="sidenav">
    <div class="brand">
        <img src="{{ asset('img/fcu-logo.png') }}" alt="filamer logo">
        <span>FCU Library Management System</span>
    </div>

    <div class="nav-links">
        <a href="/user/dashboard" class="nav-link">Dashboard</a>
        {{-- Checks if the user is allowed to access the book management --}}
        @if ($user->role->books_access)
            <a href="/books" class="nav-link">Book Management</a>
        @endif
        {{-- Checks if the user is allowed to access the patron management --}}
        @if ($user->role->patrons_access)
            <a href="/patrons" class="nav-link">Patron Management</a>
            <a href="/patron-logins" class="nav-link">Access Log</a>
        @endif
        {{-- Checks if the user is allowed to access the reports module --}}
        @if ($user->role->reports_access)
            <a href="#" class="nav-link">Reports</a>
        @endif

        {{-- Checks if the user is admin --}}
        @if ($user->role_id == 1)
            <a href="/users" class="nav-link">User Management</a>
            <a href="/activities" class="nav-link">User Activities</a>
            <a href="/options" class="nav-link">Options</a>
        @endif

        <form action="/logout" method="post">
            @csrf
            <button type="submit" class="nav-link">Logout</button>
        </form>
    </div>
</div>
