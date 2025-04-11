@extends('layout.main')
@extends('modals.filter_date')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="container p-3 rounded">
        <div class="d-flex justify-content-between">
            <div>
                <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#filterDate">Filter
                    Date</button>
                <a class="btn-simple" href="{{ route('patron-logins.export', request()->query()) }}">Export</a>
            </div>
            <!-- Form to search -->
            <form method="GET" class="d-flex flex-row align-items-center" id="filterForm">
                <input type="text" name="search" placeholder="Search by title or author"
                    value="{{ $search }}">
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
                        <td><a class="shortcut-link"
                                href="/patron/show/{{ $patron_login->patron_id }}">{{ $patron_login->patron->first_name . ' ' . $patron_login->patron->last_name }}</a>
                        </td>
                        <td>{{ $patron_login->purpose->purpose ?? 'Not specified' }}</td>
                        <td>{{ $patron_login->marketer->marketer ?? 'Not specified' }}</td>
                        <td>{{ $patron_login->login_at->format('g:i a') }}</td>
                        <td>{{ $patron_login->logout_at ? $patron_login->logout_at->format('g:i a') : '' }}
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
