@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <div class="container p-3 rounded">
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
                        <td>{{ $patron_login->login_at->format('m/d/y') }}</td>
                        <td>{{ $patron_login->patron->first_name . ' ' . $patron_login->patron->last_name }}</td>
                        <td>{{ $patron_login->purpose->purpose }}</td>
                        <td>{{ $patron_login->marketer->marketer ?? 'None' }}</td>
                        <td>{{ $patron_login->login_at->format('g:i a') }}</td>
                        <td>{{ $patron_login->logout_at ? $patron_login->logout_at->format('g:i a') : 'Not logged out' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
