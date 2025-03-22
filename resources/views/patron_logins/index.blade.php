@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.topbar')
    <div class="container p-3 rounded">
        <div class="d-flex justify-content-between">
            <!-- Form to filter -->
            <form method="GET" action="/patron-logins" class="d-flex flex-row align-items-center" id="filterForm">
                <input type="date" name="date" value="{{ $date }}">
                <button type="submit" class="btn-rectangle">Filter</button>
            </form>
            <!-- Form to search -->
            <form method="GET" action="/patron-logins" class="d-flex flex-row align-items-center" id="filterForm">
                <input type="text" name="search" class="form-control" placeholder="Search by title or author"
                    value="{{ $search }}">
                <button type="submit" class="btn-rectangle">Search</button>
            </form>
            <a href="/patron-logins" type="submit" class="btn">Show All</a>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Patron</th>
                    <th scope="col">Purpose</th>
                    <th scope="col">Marketer</th>
                    <th scope="col">Login</th>
                    <th scope="col">Logout</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patron_logins as $patron_login)
                    <tr>
                        <td>{{ $patron_login->login_at->format('d/m/y') }}</td>
                        <td><a class="shortcut-link" href="/patron/show/{{$patron_login->patron_id}}">{{ $patron_login->patron->first_name . ' ' . $patron_login->patron->last_name }}</a></td>
                        <td>{{ $patron_login->purpose->purpose ?? 'Not indicated'}}</td>
                        <td>{{ $patron_login->marketer->marketer ?? 'None' }}</td>
                        <td>{{ $patron_login->login_at->format('g:i a') }}</td>
                        <td>{{ $patron_login->logout_at ? $patron_login->logout_at->format('g:i a') : 'Not logged out' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $patron_logins->links() }}
        </div>
    </div>
@endsection
