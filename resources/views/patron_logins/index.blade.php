@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Patron</th>
            <th scope="col">Purpose</th>
            <th scope="col">Marketer</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($patron_logins as $patron_login)
            <tr>
                <td>{{$patron_login->created_at}}</td>
                <td>{{$patron_login->patron_id}}</td>
                <td>{{$patron_login->purpose_id}}</td>
                <td>{{$patron_login->marketer_id}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection