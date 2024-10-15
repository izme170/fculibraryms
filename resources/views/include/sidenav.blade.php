@php
    $user = auth()->user()->load('role');
@endphp

<div class="sidenav">
    <div class="brand">
        <img src="{{ asset('img/fcu-logo.png') }}" alt="filamer logo">
        <span>FCU Library Management System</span>
    </div>

    <div class="nav-links">
        <div class="nav-link-container">
            <x-lucide-layout-dashboard class="nav-link-icon" />
            <a href="/user/dashboard" class="nav-link">Dashboard</a>
        </div>
        {{-- Checks if the user is allowed to access the book management --}}
        @if ($user->role->books_access)
            <div class="nav-link-container">
                <x-lucide-book-copy class="nav-link-icon" />
                <a href="/books" class="nav-link">Book Management</a>
            </div>
        @endif
        {{-- Checks if the user is allowed to access the patron management --}}
        @if ($user->role->patrons_access)
            <div class="nav-link-container">
                <x-lucide-users class="nav-link-icon" />
                <a href="/patrons" class="nav-link">Patron Management</a>
            </div>
            <div class="nav-link-container">
                <x-lucide-logs class="nav-link-icon" />
                <a href="/patron-logins" class="nav-link">Access Log</a>
            </div>
        @endif
        {{-- Checks if the user is allowed to access the reports module --}}
        @if ($user->role->reports_access)
            <div class="nav-link-container">
                <x-lucide-file-pie-chart class="nav-link-icon" />
                <a href="/reports" class="nav-link">Reports</a>
            </div>
        @endif

        {{-- Checks if the user is admin --}}
        @if ($user->role_id == 1)
            <div class="nav-link-container">
                <x-lucide-user-cog class="nav-link-icon" />
                <a href="/users" class="nav-link">User Management</a>
            </div>
            <div class="nav-link-container">
                <x-lucide-clipboard-list class="nav-link-icon" />
                <a href="/activities" class="nav-link">User Activities</a>
            </div>
            <div class="nav-link-container">
                <x-lucide-settings class="nav-link-icon" />
                <a href="/options" class="nav-link">Options</a>
            </div>
        @endif
    </div>
    <form action="/logout" method="post">
        @csrf
        <div class="nav-link-container">
            <x-lucide-log-out class="nav-link-icon" />
            <button type="submit" class="nav-link">Logout</button>
        </div>
    </form>
</div>
