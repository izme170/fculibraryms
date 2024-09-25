<div class="sidenav">
    <div class="brand">
        <img src="{{asset('img/fcu-logo.png')}}" alt="filamer logo">
        <span>FCU Library Management System</span>
    </div>

    <div class="nav-links">
        <a href="/user/dashboard" class="nav-link">Dashboard</a>
        <a href="/books" class="nav-link">Book Management</a>
        <a href="/patrons" class="nav-link">Patron Management</a>
        <a href="/patron-logins" class="nav-link">Access Log</a>
        <a href="#" class="nav-link">Reports</a>
        <a href="/users" class="nav-link">User Management</a>
        <a href="/activities" class="nav-link">User Activities</a>
        <a href="/options" class="nav-link">Options</a>
        <form action="/logout" method="post">
            @csrf
            <button type="submit" class="nav-link">Logout</button>
        </form>
    </div>
</div>
