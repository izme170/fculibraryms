<div class="sidenav">
    <div class="brand">
        <img src="{{asset('img/fcu-logo.png')}}" alt="filamer logo">
        <span>FCU Library Management System</span>
    </div>

    <div class="nav-links">
        <a href="/user/dashboard" class="nav-link">Dashboard</a>
        <a href="/users" class="nav-link">Users</a>
        <a href="/books" class="nav-link">Books</a>
        <a href="/borrowed-books" class="nav-link">Borrowed Books</a>
        <a href="/patrons" class="nav-link">Patrons</a>
        <a href="/patron-logins" class="nav-link">Patron Logins</a>
        <a href="#" class="nav-link">Reports</a>
        <a href="/activities" class="nav-link">Activities</a>
        <a href="#" class="nav-link">Archives</a>
        <form action="/logout" method="post">
            @csrf
            <button type="submit" class="nav-link">Logout</button>
        </form>
    </div>
</div>
