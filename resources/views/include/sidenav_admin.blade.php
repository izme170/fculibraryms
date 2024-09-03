<div class="sidenav">
    <div class="brand">
        <img src="{{asset('img/fcu-logo.png')}}" alt="filamer logo">
        <span>FCU Library Management System</span>
    </div>

    <div class="nav-links">
        <a href="/admin/dashboard" class="nav-link">Dashboard</a>
        <a href="/admin/users" class="nav-link">Users</a>
        <a href="/admin/books" class="nav-link">Books</a>
        <a href="/borrowed-books" class="nav-link">Borrowed Books</a>
        <a href="/admin/patrons" class="nav-link">Patrons</a>
        <a href="#" class="nav-link">Reports</a>
        <a href="#" class="nav-link">Activities</a>
        <a href="#" class="nav-link">Archives</a>
        <form action="/logout" method="post">
            @csrf
            <button type="submit" class="nav-link">Logout</button>
        </form>
    </div>
</div>