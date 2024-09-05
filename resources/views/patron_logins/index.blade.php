@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
<table class="table">
    <thead class="thead-dark">
        <tr>
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
                <td>{{$patron_login->first_name. ' ' .$patron_login->last_name}}</td>
                <td>{{$patron_login->purpose}}</td>
                <td>{{$patron_login->marketer ?? 'None'}}</td>
                <td>{{$patron_login->login_at}}</td>
                <td>{{$patron_login->logout_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection