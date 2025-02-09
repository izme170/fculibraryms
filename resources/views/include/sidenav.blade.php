@php
    $user = auth()->user()->load('role');
@endphp

<div class="sidenav-toggle" id="sidenav-toggle">
    ☰
</div>

<div class="sidenav" id="sidenav">
    <div class="brand">
        <img src="{{ asset('img/fcu-logo.png') }}" alt="filamer logo">
        <span>FCU Library Management System</span>
    </div>

    <div class="nav-links">
        <a href="/user/dashboard" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <x-lucide-layout-dashboard class="nav-link-icon" />
            <span>Dashboard</span>
        </a>

        {{-- Checks if the user is admin --}}
        @if ($user->role_id == 1)
            <a href="/users" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <x-lucide-user-cog class="nav-link-icon" />
                <span>User Management</span>
            </a>
        @endif

        {{-- Checks if the user is allowed to access the book management --}}
        @if ($user->role->books_access)
            <a href="/books" class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
                <x-lucide-book-copy class="nav-link-icon" />
                <span>Book Management</span>
            </a>
        @endif

        {{-- Checks if the user is allowed to access the patron management --}}
        @if ($user->role->patrons_access)
            <a href="/patrons" class="nav-link {{ request()->routeIs('patrons.*') ? 'active' : '' }}">
                <x-lucide-users class="nav-link-icon" />
                <span>Patron Management</span>
            </a>
        @endif

        {{-- Checks if the user is allowed to access the reports module --}}
        @if ($user->role->reports_access)
            <a href="/reports" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <x-lucide-file-pie-chart class="nav-link-icon" />
                <span>Reports</span>
            </a>
        @endif

        {{-- Checks if the user is allowed to access the patron management --}}
        @if ($user->role->patrons_access)
            <a href="/patron-logins" class="nav-link {{ request()->routeIs('patron-logins.*') ? 'active' : '' }}">
                <x-lucide-logs class="nav-link-icon" />
                <span>Access Log</span>
            </a>
        @endif

        {{-- Checks if the user is admin --}}
        @if ($user->role_id == 1)
            <a href="/activities" class="nav-link {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                <x-lucide-clipboard-list class="nav-link-icon" />
                <span>User Activities</span>
            </a>
            <a href="/data-entry" class="nav-link {{ request()->routeIs('data-entry.*') ? 'active' : '' }}">
                <x-lucide-pencil-line class="nav-link-icon" />
                <span>Data Entry</span>
            </a>
        @endif
    </div>

    <form action="/logout" method="post">
        @csrf
        <div class="nav-link">
            <button type="submit" class="nav-link"><x-lucide-log-out class="nav-link-icon" /> Logout</button>
        </div>
    </form>
</div>

<script>
    const toggleSideNav = document.getElementById("sidenav-toggle");
    const sideNav = document.getElementById("sidenav");

    toggleSideNav.addEventListener("click", function() {
        sideNav.classList.toggle('sidenav-on')
    })
</script>
